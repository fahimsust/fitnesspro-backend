<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\UpdateProductDetailsTypeRequest;
use Domain\Products\Actions\Product\UpdateProductDetailsType;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UpdateProductDetailsTypeController extends AbstractController
{
    public function __invoke(Product $product, UpdateProductDetailsTypeRequest $request)
    {
        return response(
            UpdateProductDetailsType::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
