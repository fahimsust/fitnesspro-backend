<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductImageSearchRequest;
use Domain\Products\Models\Product\ProductImage;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductImagesController extends AbstractController
{
    public function __invoke(ProductImageSearchRequest $request)
    {
        return response(
            ProductImage::search($request)
            ->when(
                $request->filled('order_by'),
                fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
            )
            ->with('image')
            ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
