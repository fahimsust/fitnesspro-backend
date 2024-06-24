<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\CreateProductRequest;
use App\Api\Admin\Products\Requests\ProductBasicsRequest;
use App\Api\Admin\Products\Requests\ProductSearchRequest;
use Domain\Products\Actions\Product\CreateProduct;
use Domain\Products\Actions\Product\DeleteProduct;
use Domain\Products\Actions\Product\UpdateProductBasics;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    public function index(ProductSearchRequest $request)
    {
        return response(
            Product::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(CreateProductRequest $request)
    {
        return response(
            CreateProduct::run($request),
            Response::HTTP_CREATED
        );
    }

    public function update(Product $product, ProductBasicsRequest $request)
    {
        return response(
            UpdateProductBasics::run($product, $request),
            Response::HTTP_CREATED
        );
    }

    public function show(int $productId)
    {
        return response(
            Product::with(
                'details'
            )
                ->withCount('options')->findOrFail($productId),
            Response::HTTP_OK
        );
    }

    public function destroy(Product $product)
    {
        return response(
            DeleteProduct::run($product),
            Response::HTTP_OK
        );
    }
}
