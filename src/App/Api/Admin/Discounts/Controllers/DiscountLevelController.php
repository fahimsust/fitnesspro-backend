<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountLevelRequest;
use Domain\Discounts\Actions\Admin\CreateDiscountLevel;
use Domain\Discounts\Actions\Admin\UpdateDiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevel;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountLevelController extends AbstractController
{
    public function index()
    {
        return Response(
            DiscountLevel::all(),
            Response::HTTP_OK
        );
    }
    public function store(DiscountLevelRequest $request)
    {
        return response(
            CreateDiscountLevel::run($request),
            Response::HTTP_CREATED
        );
    }
    public function update(DiscountLevel $discountLevel, DiscountLevelRequest $request)
    {
        return response(
            UpdateDiscountLevel::run($discountLevel, $request),
            Response::HTTP_CREATED
        );
    }

    public function show(DiscountLevel $discountLevel)
    {
        $discountLevel->loadCount('products');
        return response(
            $discountLevel,
            Response::HTTP_OK
        );
    }
}
