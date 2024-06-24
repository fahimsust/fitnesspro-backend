<?php

namespace App\Api\Admin\Products\Types\Controllers;

use App\Api\Admin\Products\Types\Requests\ProductTypeTaxRuleRequest;
use Domain\Products\Actions\Types\AssignTaxRuleToProductType;
use Domain\Products\Actions\Types\RemoveTaxRuleFromProductType;
use Domain\Products\Models\Product\ProductType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTypeTaxRuleController extends AbstractController
{
    public function index(ProductType $productType)
    {
        return response(
            $productType->taxRules,
            Response::HTTP_OK
        );
    }

    public function store(ProductType $productType,ProductTypeTaxRuleRequest $request)
    {
        return response(
            AssignTaxRuleToProductType::run($productType, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(ProductType $productType, int $tax_rule_id)
    {
        return response(
            RemoveTaxRuleFromProductType::run($productType, $tax_rule_id),
            Response::HTTP_OK
        );
    }
}
