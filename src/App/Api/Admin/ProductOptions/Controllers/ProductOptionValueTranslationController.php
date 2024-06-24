<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\ProductOptionValueTranslationRequest;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionValueTranslationController extends AbstractController
{
    public function update(ProductOptionValue $productOptionValue,int $language_id, ProductOptionValueTranslationRequest $request)
    {
        return response(
            $productOptionValue->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'name' => $request->name,
                'display' => $request->display
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $product_option_value_id,int $language_id)
    {
        return response(
            ProductOptionValueTranslation::where('product_option_value_id',$product_option_value_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
