<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\CreateDateOptionValuesRequest;
use Domain\Products\Actions\ProductOptions\CreateDateOptionValues;
use Domain\Products\Models\Product\Option\ProductOption;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CreateDateOptionValuesControllers extends AbstractController
{
    public function __invoke(CreateDateOptionValuesRequest $request,ProductOption $productOption)
    {
        return response(
            CreateDateOptionValues::run($request,$productOption),
            Response::HTTP_CREATED
        );
    }
}
