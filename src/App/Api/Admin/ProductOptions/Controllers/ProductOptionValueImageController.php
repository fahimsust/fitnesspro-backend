<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\ProductOptionValueImageRequest;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionValueImageController extends AbstractController
{
    public function store(ProductOptionValue $productOptionValue, ProductOptionValueImageRequest $request)
    {
        $productOptionValue->update(['image_id' => $request->image_id]);

        return response(
            $productOptionValue,
            Response::HTTP_CREATED
        );
    }
}
