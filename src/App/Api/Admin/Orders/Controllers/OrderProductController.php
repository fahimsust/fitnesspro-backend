<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderProductController extends AbstractController
{
    public function __invoke(int $productId)
    {
        return response(
            Product::with(
                'details',
                'defaultDistributor',
                'detailsImage',
                'accessories',
                'accessories.options',
                'accessories.options',
                'accessories.options.optionValues',
                'accessories.options.optionValues.custom',
                'options',
                'options.optionValues',
                'options.optionValues.custom',
                'customForms',
                'customForms.sections',
                'customForms.sections.fields',
                'customForms.sections.fields.options',
            )->findOrFail($productId),
            Response::HTTP_OK
        );
    }
}
