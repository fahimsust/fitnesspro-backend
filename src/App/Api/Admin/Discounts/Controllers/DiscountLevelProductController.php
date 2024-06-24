<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountLevelProductRequest;
use Domain\Discounts\Actions\Admin\AssignProductToDiscountLevel;
use Domain\Discounts\Actions\Admin\RemoveProductFromDiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevel;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountLevelProductController extends AbstractController
{
    public function index(DiscountLevel $discountLevel)
    {
        return response(
            $discountLevel->products,
            Response::HTTP_OK
        );
    }

    public function store(DiscountLevel $discountLevel, DiscountLevelProductRequest $request)
    {
        return response(
            AssignProductToDiscountLevel::run($discountLevel, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(DiscountLevel $discountLevel, int $productId)
    {
        return response(
            RemoveProductFromDiscountLevel::run($discountLevel, $productId),
            Response::HTTP_OK
        );
    }
}
