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

class GetProductByKeywordMatch
{
    use AsObject;

    const LIMIT = 1000;

    public function handle(FindRequest $request)
    {
        GetKeywordError::run($request);

        if (strpos($request->column, "pd.") !== false) {
            return $this->getProductsByDetailColumn($request);
        }

        if (strpos($request->column, "po.") !== false) {
            return $this->getProductsByOptionColumn($request);
        }

        if (strpos($request->column, "pov.") !== false) {
            return $this->getProductsByOptionValueColumn($request);
        }

        return $this->getProductsByColumn($request);
    }

    private function getProductsByDetailColumn(FindRequest $request)
    {
        $column = str_replace("pd.", "", $request->column);
        $productIds = $request->language_id ?
            ProductTranslation::where($column, $request->keyword)->where('language_id', $request->language_id)->groupBy('product_id')->limit(self::LIMIT)->get() :
            ProductDetail::where($column, $request->keyword)->groupBy('product_id')->limit(self::LIMIT)->get();

        return $productIds ? Product::whereIn('id', $productIds->pluck('product_id')->toArray())->limit(self::LIMIT)->get() : [];
    }

    private function getProductsByOptionColumn(FindRequest $request)
    {
        $column = str_replace("po.", "", $request->column);
        $productOptions = $request->language_id ?
            ProductOption::whereHas('translations', function (Builder $query) use ($column, $request) {
                $query->where($column, $request->keyword)->where('language_id', $request->language_id);
            })->groupBy('product_id')->limit(self::LIMIT)->get() :
            ProductOption::where($column, $request->keyword)->groupBy('product_id')->limit(self::LIMIT)->get();

        return $productOptions ? Product::whereIn('id', $productOptions->pluck('product_id')->toArray())->limit(self::LIMIT)->get() : [];
    }

    private function getProductsByOptionValueColumn(FindRequest $request)
    {
        $column = str_replace("pov.", "", $request->column);

        $productOptions = $request->language_id ?
            ProductOption::whereHas('optionValues.translations', function (Builder $query) use ($column, $request) {
                $query->where($column, $request->keyword)->where('language_id', $request->language_id);
            })->groupBy('product_id')->limit(self::LIMIT)->get() :
            ProductOption::whereHas('optionValues', function (Builder $query) use ($column, $request) {
                $query->where($column, $request->keyword);
            })->groupBy('product_id')->limit(self::LIMIT)->get();

        return $productOptions ? Product::whereIn('id', $productOptions->pluck('product_id')->toArray())->limit(self::LIMIT)->get() : [];
    }

    private function getProductsByColumn(FindRequest $request)
    {
        $column = str_replace("p.", "", $request->column);
        return $request->language_id ?
            Product::whereHas('translations', function (Builder $query) use ($column, $request) {
                $query->where($column, $request->keyword)->where('language_id', $request->language_id);
            })->limit(self::LIMIT)->get() :
            Product::where($column, $request->keyword)->limit(self::LIMIT)->get();
    }
}
