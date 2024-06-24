<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductTranslationDetailsRequest;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTranslationContentController extends AbstractController
{
    public function update(Product $product,int $language_id,  ProductTranslationDetailsRequest $request)
    {
        return response(
            $product->translations()->updateOrCreate(
                [
                    'language_id'=>$language_id
                ],
                [
                    'summary' => $request->summary,
                    'description' => $request->description
                ]),
            Response::HTTP_CREATED
        );
    }
}
