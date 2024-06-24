<?php

namespace App\Api\Admin\Products\Types\Controllers;

use Domain\Products\Models\Product\ProductType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTypeAttributesController extends AbstractController
{
    public function __invoke(int $productType)
    {
        return response(
            ProductType::whereId($productType)->with(
                [
                    'attributeSets' => function ($query) {
                        $query->with(
                            [
                                'attributes' => function ($attributeQuery) {
                                    $attributeQuery->with(['options']);
                                }
                            ]
                        );
                    }
                ]
            )->first(),
            Response::HTTP_OK
        );
    }
}
