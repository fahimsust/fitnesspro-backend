<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductTranslationMetaDataRequest;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTranslationMetaDataController extends AbstractController
{
    public function update(Product $product,int $language_id,  ProductTranslationMetaDataRequest $request)
    {
        return response(
            $product->translations()->updateOrCreate(
                [
                    'language_id'=>$language_id
                ],
                [
                    'meta_title' => $request->meta_title,
                    'meta_desc' => $request->meta_desc,
                    'meta_keywords' => $request->meta_keywords,
                ]),
            Response::HTTP_CREATED
        );
    }
}
