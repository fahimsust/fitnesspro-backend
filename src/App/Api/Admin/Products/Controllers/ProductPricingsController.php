<?php

namespace App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ProductPricingsController extends AbstractController
{
    public function __invoke(Product $product,Request $request)
    {
        return response(
            ProductPricing::whereHas('product', function ($query) use ($product,$request) {
                $query->where('products.parent_product', $product->id)->basicKeywordSearch($request?->keyword);
             })
             ->when(
                $request->filled('site_id'),
                fn ($query) => $query->where('site_id',$request->site_id)
            )
            ->when(
                $request->filled('order_by'),
                fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
            )
             ->with('site','orderingRule','pricingRule','product')->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
