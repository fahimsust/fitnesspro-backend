<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetKeywordError;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductTranslation;
use Illuminate\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByKeywordExists
{
    use AsObject;

    const LIMIT = 1000;

    public function handle(FindRequest $request)
    {
        GetKeywordError::run($request);

        if (strpos($request->column, "pd.") !== false) {
            return $this->handleProductDetailSearch($request);
        } elseif (strpos($request->column, "po.") !== false) {
            return $this->handleProductOptionSearch($request);
        } elseif (strpos($request->column, "pov.") !== false) {
            return $this->handleProductOptionValueSearch($request);
        } else {
            return $this->handleProductSearch($request);
        }
    }

    protected function handleProductDetailSearch($request)
    {
        $column = str_replace("pd.", "", $request->column);

        if ($request->language_id) {
            $productIds = ProductTranslation::where($column, 'LIKE', "%{$request->keyword}%")
                ->where('language_id', $request->language_id)
                ->limit(self::LIMIT)
                ->pluck('product_id');
        } else {
            $productIds = ProductDetail::where($column, 'LIKE', "%{$request->keyword}%")
                ->limit(self::LIMIT)
                ->pluck('product_id');
        }

        return $this->getProductsByIds($productIds);
    }

    protected function handleProductOptionSearch($request)
    {
        $column = str_replace("po.", "", $request->column);

        if ($request->language_id) {
            $productOptions = ProductOption::whereHas('translations', function (Builder $query) use ($column, $request) {
                $query->where($column, 'LIKE', "%{$request->keyword}%")
                    ->where('language_id', $request->language_id);
            })
            ->limit(self::LIMIT)
            ->pluck('product_id');
        } else {
            $productOptions = ProductOption::where($column, 'LIKE', "%{$request->keyword}%")
                ->limit(self::LIMIT)
                ->pluck('product_id');
        }

        return $this->getProductsByIds($productOptions);
    }

    protected function handleProductOptionValueSearch($request)
    {
        $column = str_replace("pov.", "", $request->column);

        if ($request->language_id) {
            $productOptions = ProductOption::whereHas('optionValues', function (Builder $query) use ($column, $request) {
                $query->whereHas('translations', function (Builder $query) use ($column, $request) {
                    $query->where($column, 'LIKE', "%{$request->keyword}%")
                        ->where('language_id', $request->language_id);
                });
            })
            ->limit(self::LIMIT)
            ->pluck('product_id');
        } else {
            $productOptions = ProductOption::whereHas('optionValues', function (Builder $query) use ($column, $request) {
                $query->where($column, 'LIKE', "%{$request->keyword}%");
            })
            ->limit(self::LIMIT)
            ->pluck('product_id');
        }

        return $this->getProductsByIds($productOptions);
    }

    protected function handleProductSearch($request)
    {
        $column = str_replace("p.", "", $request->column);

        if ($request->language_id) {
            return Product::whereHas('translations', function (Builder $query) use ($column, $request) {
                $query->where($column, 'LIKE', "%{$request->keyword}%")
                    ->where('language_id', $request->language_id);
            })
            ->limit(self::LIMIT)
            ->get();
        } else {
            return Product::where($column, 'LIKE', "%{$request->keyword}%")
                ->limit(self::LIMIT)
                ->get();
        }
    }

    protected function getProductsByIds($ids)
    {
        return Product::whereIn('id', $ids)
            ->limit(self::LIMIT)
            ->get();
    }
}
