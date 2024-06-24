<?php

namespace App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductFormRequest;
use Domain\CustomForms\Models\CustomForm;
use Domain\Products\Actions\Product\GetProductForm;
use Domain\Products\Actions\Product\SetProductCustomForm;
use Domain\Products\Models\Product\Product;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductFormController extends AbstractController
{
    public function index(Product $product)
    {
        return response(
            $product->load('productForms.form'),
            Response::HTTP_OK
        );
    }
    public function store(Product $product, ProductFormRequest $request)
    {
        return response(
            SetProductCustomForm::run($product, $request),
            Response::HTTP_CREATED
        );
    }
    public function destroy(Product $product, CustomForm $form)
    {
        return response(
            GetProductForm::run($product, $form)->delete(),
            Response::HTTP_OK
        );
    }
}
