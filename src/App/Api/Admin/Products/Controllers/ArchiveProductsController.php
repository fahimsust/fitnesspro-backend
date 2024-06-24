<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ArchiveProductsRequest;
use App\Api\Admin\Products\Requests\ProductsArchiveRequest;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArchiveProductsController extends AbstractController
{
    //restore product
    public function store(ArchiveProductsRequest $request)
    {
        return response(
            Product::onlyTrashed()
                ->whereIn('id', $request->product_ids)
                ->restore(),
            Response::HTTP_CREATED
        );
    }

    //archive product
    public function destroy(ProductsArchiveRequest $request)
    {
        return response(
            Product::whereIn('id', $request->product_ids)->delete(),
            Response::HTTP_CREATED
        );
    }
}
