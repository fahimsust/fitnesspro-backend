<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\CustomFieldOptionValueRequest;
use Domain\Products\Actions\ProductOptions\RemoveCustomFieldFromOptionValue;
use Domain\Products\Actions\ProductOptions\SetupCustomFieldOnOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionValueCustomFieldController extends AbstractController
{
    public function index(ProductOptionValue $productOptionValue)
    {
        return response(
            $productOptionValue->custom,
            Response::HTTP_OK
        );
    }

    public function store(ProductOptionValue $productOptionValue, CustomFieldOptionValueRequest $request)
    {
        return response(
            SetupCustomFieldOnOptionValue::run($productOptionValue, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(ProductOptionValue $productOptionValue)
    {
        return response(
            RemoveCustomFieldFromOptionValue::run($productOptionValue),
            Response::HTTP_OK
        );
    }
}
