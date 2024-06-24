<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\CreateOrderTransactionsRequest;
use Domain\Orders\Actions\Order\CreateCharge;
use Domain\Orders\Actions\Order\Transaction\LoadOrderTransactionsByOrderId;
use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderTransactionsController extends AbstractController
{
    public function index(Order $order)
    {
        return response(
            LoadOrderTransactionsByOrderId::run($order->id),
            Response::HTTP_OK
        );
    }

    public function store(
        Order                          $order,
        CreateOrderTransactionsRequest $request
    )
    {
        return response(
            CreateCharge::now($order, $request),
            Response::HTTP_CREATED
        );
    }
}
