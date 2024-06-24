<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\CreateOrderNoteRequest;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderItemNoteController extends AbstractController
{
    public function __invoke(OrderItem $orderItem, CreateOrderNoteRequest $request)
    {
        return response(
            $orderItem->update([
                'product_notes' => $request->note
            ]),
            Response::HTTP_CREATED
        );
    }
}
