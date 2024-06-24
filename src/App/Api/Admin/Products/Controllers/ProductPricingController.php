<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductPricingRequest;
use Domain\Products\Actions\pricing\UpdateProductPricing;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductPricingController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            [
                'default' =>
                ProductPricing::where('product_id', $product->id)
                    ->where('site_id', null)
                    ->with('site', 'orderingRule', 'pricingRule')->get(),
                'site' => Site::withWhereHas(
                    'pricing',
                    fn ($query) =>
                    $query->where('product_id', $product->id)->with('site', 'orderingRule', 'pricingRule')
                )->get()
            ],
            Response::HTTP_OK
        );
    }
    public function store(Product $product, ProductPricingRequest $request)
    {
        return response(
            UpdateProductPricing::run($product, $request),
            Response::HTTP_CREATED
        );
    }
    public function show(Product $product,int $id)
    {
        return response(
            ProductPricing::whereProductId($product->id)->whereId($id)->with('site','orderingRule','pricingRule')->first(),
            Response::HTTP_CREATED
        );

    }
}
