<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetKeywordReplaceError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class ReplaceProductFieldSubtextWithText
{
    use AsObject;

    public function handle(PerformRequest $request): int
    {
        GetKeywordReplaceError::run($request);

        if (strpos($request->column, "pd.") !== false) {
            $this->replaceInProductDetail($request);
        } elseif (strpos($request->column, "po.") !== false) {
            $this->replaceInProductOption($request);
        } elseif (strpos($request->column, "pov.") !== false) {
            $this->replaceInProductOptionValue($request);
        } else {
            $this->replaceInProduct($request);
        }

        return CreateActivity::run(
            $request->ids,
            [
                'field' => $request->column,
                'keyword' => $request->keyword,
                'replace' => $request->replace,
            ],
            ActionList::REPLACE_SUBTEXT_WITH_TEXT
        );
    }

    private function replaceInProductDetail(PerformRequest $request): void
    {
        $column = str_replace("pd.", "", $request->column);
        $query = $request->language_id ? ProductTranslation::whereIn('product_id', $request->ids) : ProductDetail::whereIn('product_id', $request->ids);
        $query->where($column, 'LIKE', "%{$request->keyword}%")->update([
            $column => DB::raw("REPLACE($column,'$request->keyword','$request->replace')")
        ]);
    }

    private function replaceInProductOption(PerformRequest $request): void
    {
        $column = str_replace("po.", "", $request->column);
        $options = ProductOption::whereIn('product_id', $request->ids)->get()->pluck('id')->toArray();

        if (!$options) return;

        $query = $request->language_id ? ProductOptionTranslation::whereIn('product_option_id', $options) : ProductOption::whereIn('product_id', $request->ids);
        $query->where($column, 'LIKE', "%{$request->keyword}%")->update([
            $column => DB::raw("REPLACE($column,'$request->keyword','$request->replace')")
        ]);
    }

    private function replaceInProductOptionValue(PerformRequest $request): void
    {
        $column = str_replace("pov.", "", $request->column);
        $options = ProductOption::whereIn('product_id', $request->ids)->get()->pluck('id')->toArray();

        if (!$options) return;

        $optionValues = ProductOptionValue::whereIn('option_id', $options)->get()->pluck('id')->toArray();

        if (!$optionValues) return;

        $query = $request->language_id ? ProductOptionValueTranslation::whereIn('product_option_value_id', $optionValues) : ProductOptionValue::whereIn('option_id', $options);
        $query->where($column, 'LIKE', "%{$request->keyword}%")->update([
            $column => DB::raw("REPLACE($column,'$request->keyword','$request->replace')")
        ]);
    }

    private function replaceInProduct(PerformRequest $request): void
    {
        $column = str_replace("p.", "", $request->column);
        $query = $request->language_id ? ProductTranslation::whereIn('product_id', $request->ids) : Product::whereIn('id', $request->ids);
        $query->where($column, 'LIKE', "%{$request->keyword}%")->update([
            $column => DB::raw("REPLACE($column,'$request->keyword','$request->replace')")
        ]);
    }
}
