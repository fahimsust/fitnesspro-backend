<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductWaitingVariantRequest;
use Domain\Products\Actions\ProductOptions\CreateVariantsWithOptionValueIds;
use Domain\Products\Actions\ProductOptions\GetAwaitingVariantsCollectionFromComboIds;
use Domain\Products\Actions\ProductOptions\GetCombosAwaitingVariant;
use Domain\Products\Actions\ProductOptions\GetGroupedProductOptionValuesForCombinationIds;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductWaitingVariantController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            GetGroupedProductOptionValuesForCombinationIds::run(
                GetCombosAwaitingVariant::run($product)
            ),
            Response::HTTP_OK
        );
    }
    public function store(Product $product, ProductWaitingVariantRequest $request)
    {
        return response(
            CreateVariantsWithOptionValueIds::run(
                $product,
                collect($request->option_values)
            ),
            Response::HTTP_OK
        );
    }
}
