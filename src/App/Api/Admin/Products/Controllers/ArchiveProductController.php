<?php

namespace App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArchiveProductController extends AbstractController
{
//    public function index(Request $request)
//    {
//        return response(
//            Product::onlyTrashed()->paginate($request?->per_page),
//            Response::HTTP_OK
//        );
//    }

    //restore product
    public function store(int $productId)
    {
        return response(
            Product::onlyTrashed()
                ->findOrFail($productId, 'id')
                ->restore(),
            Response::HTTP_CREATED
        );
    }

    //Archive Product
    public function destroy(Product $product)
    {
        return response(
            $product->delete(),
            Response::HTTP_OK
        );
    }
}
