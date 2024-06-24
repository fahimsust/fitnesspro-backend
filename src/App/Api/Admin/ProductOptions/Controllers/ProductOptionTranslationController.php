<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\ProductOptionTranslationRequest;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionTranslationController extends AbstractController
{
    public function update(ProductOption $productOption,int $language_id, ProductOptionTranslationRequest $request)
    {
        return response(
            $productOption->translations()->updateOrCreate(
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

    public function show(int $product_option_id,int $language_id)
    {
        return response(
            ProductOptionTranslation::where('product_option_id',$product_option_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
