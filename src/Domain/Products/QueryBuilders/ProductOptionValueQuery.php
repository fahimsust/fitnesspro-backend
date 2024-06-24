<?php

namespace Domain\Products\QueryBuilders;

use App\Api\Admin\ProductOptions\Requests\OptionValuesSearchRequest;
use Domain\Products\Models\Product\Option\ProductOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductOptionValueQuery extends Builder
{
    public static function realDisplaySelect($fieldName = "display")
    {
        return DB::raw(
            "IF(start_date IS NOT NULL, REPLACE(REPLACE($fieldName , '{END_DATE}', DATE_FORMAT(end_date, '"
            . config('products.option_value_sql_dateformat') . "')), '{START_DATE}', DATE_FORMAT(start_date, '"
            . config('products.option_value_sql_dateformat') . "')), $fieldName) as real_display"
        );
    }

    public function forOptionValueComboIds(Collection|array $arrayOfComboOptionValueIds)
    {

        if ($arrayOfComboOptionValueIds instanceof Collection) {
            $arrayOfComboOptionValueIds = $arrayOfComboOptionValueIds->toArray();
        }

        return $this
            ->where('products_options_values.status', true)
            ->whereIn(
                "products_options_values.id",
                array_unique(
                    array_merge(...array_values($arrayOfComboOptionValueIds))
                )
            )
            ->orderBy('products_options_values.option_id', 'ASC')
            ->orderBy('products_options_values.rank', 'ASC');
    }

    public function basicKeywordSearch(?string $keyword)
    {
        return $this->like(['name', 'display'], $keyword);
    }

    public function forOption(ProductOption $productOption): static
    {
        return $this->whereOptionId($productOption->id);
    }

    public function search(OptionValuesSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn() => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->anyFilled(['start_date', 'end_date'])) {
            if ($request->Filled(['start_date', 'end_date'])) {
                $this->where(function ($query) use ($request) {
                    $query->where(function ($queryMain) use ($request) {
                        $queryMain->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->start_date);
                    });
                    $query->orWhere(function ($queryMain) use ($request) {
                        $queryMain->where('start_date', '<=', $request->end_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
                    $query->orWhere(function ($queryMain) use ($request) {
                        $queryMain->where('start_date', '>=', $request->start_date)
                            ->where('start_date', '<=', $request->end_date);
                    });
                    $query->orWhere(function ($queryMain) use ($request) {
                        $queryMain->where('end_date', '>=', $request->start_date)
                            ->where('end_date', '<=', $request->end_date);
                    });
                });
            } else if ($request->Filled('start_date')) {
                $this->where('start_date', '<=', $request->start_date)
                    ->where('end_date', '>=', $request->start_date);
            } else if ($request->Filled('end_date')) {
                $this->where('start_date', '<=', $request->end_date)
                    ->where('end_date', '>=', $request->end_date);
            }
        }
        return $this;
    }
}
