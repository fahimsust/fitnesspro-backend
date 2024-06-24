<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\UpdateProductOptionValueRequest;
use App\Api\Admin\ProductOptions\Requests\CreateProductOptionValueRequest;
use Domain\Products\Actions\ProductOptions\DeleteProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionValueController extends AbstractController
{
    public function store(CreateProductOptionValueRequest $request)
    {
        return response(
            ProductOptionValue::create([
                'option_id' => $request->option_id,
                'name' => $request->display,
                'display' => $request->display,
                'price' => $request->price,
                'rank' => $request->rank
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(ProductOptionValue $productOptionValue, UpdateProductOptionValueRequest $request)
    {
        return response(
            $productOptionValue->update([
                'name' => $request->name,
                'display' => $request->display,
                'rank' => $request->rank,
                'price' => $request->price,
            ]),
            Response::HTTP_CREATED
        );
    }

    //To Do
    public function destroy(ProductOptionValue $productOptionValue)
    {
        return response(
            DeleteProductOptionValue::run($productOptionValue),
            Response::HTTP_OK
        );
    }
}
