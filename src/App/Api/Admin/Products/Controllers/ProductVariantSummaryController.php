<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductSearchRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductVariantSummaryController extends AbstractController
{
    public function __invoke(Product $product,ProductSearchRequest $request)
    {
        return response(
            Product::query()
                ->select(DB::raw('count(id) as total, sum(combined_stock_qty) as total_stock_qty'))
                ->forParentProduct($product->id)
                ->whereHas('optionValues')
                ->search($request)
                ->first(),
            Response::HTTP_OK
        );
    }

}
