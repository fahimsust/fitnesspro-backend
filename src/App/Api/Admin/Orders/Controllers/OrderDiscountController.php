<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\CreateOrderDiscountRequest;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Order\Discount\ApplyDiscountToOrder;
use Domain\Orders\Actions\Order\Discount\RemoveDiscountFromOrder;
use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderDiscountController extends AbstractController
{
    public function store(Order $order, CreateOrderDiscountRequest $request)
    {
        return response(
            ApplyDiscountToOrder::now($order, Discount::find($request->discount_id)),
            Response::HTTP_OK
        );
    }
    public function destroy(Order $order, Discount $discount)
    {
        return response(
            RemoveDiscountFromOrder::now($order, $discount),
            Response::HTTP_OK
        );
    }
}
