<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Option\ProductOptionType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionTypesController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return response(
            collect(
                ProductOptionTypes::cases()
            )
            ->map(
                fn(ProductOptionTypes $type) => [
                    'id' => $type->value,
                    'name' => $type->label(),
                ]
            ),
            Response::HTTP_OK
        );
    }
}
