<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductTranslationBasicsRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTranslationController extends AbstractController
{
    public function update(Product $product,int $language_id, ProductTranslationBasicsRequest $request)
    {
        return response(
            $product->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'title' => $request->title,
                'url_name' => $request->url_name,
                'subtitle' => $request->subtitle,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $product_id,int $language_id)
    {
        return response(
            ProductTranslation::where('product_id',$product_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
