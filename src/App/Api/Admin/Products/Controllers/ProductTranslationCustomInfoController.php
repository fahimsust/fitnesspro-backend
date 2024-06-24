<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductTranslationCustomsInfoRequest;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTranslationCustomInfoController extends AbstractController
{
    public function update(Product $product,int $language_id,  ProductTranslationCustomsInfoRequest $request)
    {
        return response(
            $product->translations()->updateOrCreate(
                [
                    'language_id'=>$language_id
                ],
                [
                    'customs_description' => $request->customs_description,
                ]),
            Response::HTTP_CREATED
        );
    }
}
