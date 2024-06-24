<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetDetailsTemplateError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByDetailsTemplate
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetDetailsTemplateError::run($request);
        $productDetails = ProductSiteSettings::where('product_detail_template', $request->template_id)
            ->groupBy('product_id')
            ->limit(1000)
            ->get();
        if ($productDetails) {
            $products = Product::whereIn('id', $productDetails->pluck('product_id')->toArray())->limit(1000)->get();
        }

        return $products;
    }
}
