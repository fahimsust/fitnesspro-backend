<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountStatusRequest;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Level\DiscountLevel;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountLevelStatusController extends AbstractController
{
    public function __invoke(DiscountLevel $discountLevel, DiscountStatusRequest $request)
    {
        $discountLevel->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $discountLevel,
            Response::HTTP_CREATED
        );
    }
}
