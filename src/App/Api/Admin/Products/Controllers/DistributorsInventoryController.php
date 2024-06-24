<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\DistributorsInventoryRequest;
use Domain\Products\Actions\Distributors\GetDistributorVariantInventory;
use Domain\Products\Actions\Product\UpdateOrCreateDistributorInventory;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DistributorsInventoryController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            GetDistributorVariantInventory::run($product),
            Response::HTTP_OK
        );
    }
    public function store(Product $product, DistributorsInventoryRequest $request)
    {
        return response(
            UpdateOrCreateDistributorInventory::run($product, $request),
            Response::HTTP_CREATED
        );
    }
}
