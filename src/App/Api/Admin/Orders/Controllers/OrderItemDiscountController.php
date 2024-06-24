<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\OrderItemsRequest;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Order\Discount\AddDiscountToOrderItems;
use Domain\Orders\Actions\Order\Discount\RemoveDiscountFromOrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemDiscountController extends AbstractController
{
    public function store(Discount $discount, OrderItemsRequest $request)
    {
        return response(
            AddDiscountToOrderItems::now($discount, $request->items),
            Response::HTTP_OK
        );
    }
    public function destroy(Discount $discount, OrderItem $item)
    {
        return response(
            RemoveDiscountFromOrderItem::now($item, $discount),
            Response::HTTP_OK
        );
    }
}
