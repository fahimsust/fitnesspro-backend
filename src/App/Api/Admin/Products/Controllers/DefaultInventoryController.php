<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\DefaultInventoryRequest;
use Domain\Products\Actions\Product\UpdateDefaultInventory;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultInventoryController extends AbstractController
{
    public function store(Product $product, DefaultInventoryRequest $request)
    {
        return response(
            UpdateDefaultInventory::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
