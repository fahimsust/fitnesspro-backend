<?php

namespace App\Api\Admin\Discounts\Controllers;

use App\Api\Admin\Discounts\Requests\DiscountStatusRequest;
use Domain\Discounts\Models\Discount;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DiscountStatusController extends AbstractController
{
    public function __invoke(Discount $discount, DiscountStatusRequest $request)
    {
        $discount->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $discount,
            Response::HTTP_CREATED
        );
    }
}
