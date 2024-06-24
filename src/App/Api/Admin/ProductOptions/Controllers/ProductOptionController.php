<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\UpdateProductOptionRequest;
use App\Api\Admin\ProductOptions\Requests\CreateProductOptionRequest;
use App\Api\Admin\ProductOptions\Requests\GetProductOptionRequest;
use Domain\Products\Actions\ProductOptions\DeleteProductOption;
use Domain\Products\Models\Product\Option\ProductOption;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionController extends AbstractController
{
    public function index(GetProductOptionRequest $request)
    {
        return response(
            ProductOption::query()
                ->forProduct($request->product_id)
                ->keywordSearch($request->keyword)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(CreateProductOptionRequest $request)
    {
        return response(
            ProductOption::create([
                'name' => $request->name,
                'display' => $request->display,
                'type_id' => $request->type_id,
                'product_id' => $request->product_id
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(ProductOption $productOption, UpdateProductOptionRequest $request)
    {
        return response(
            $productOption->update([
                'name' => $request->name,
                'display' => $request->display,
                'rank' => $request->rank,
                'show_with_thumbnail' => $request->show_with_thumbnail
            ]),
            Response::HTTP_CREATED
        );
    }

    public function destroy(ProductOption $productOption)
    {
        return response(
            DeleteProductOption::run($productOption),
            Response::HTTP_OK
        );
    }
}
