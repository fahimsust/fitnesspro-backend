<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\CreateOrderAddressRequest;
use Domain\Orders\Actions\Order\Address\AssignAddressToOrder;
use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderAddressController extends AbstractController
{
    public function __invoke(Order $order, CreateOrderAddressRequest $request)
    {
        return response(
            AssignAddressToOrder::now($order, $request),
            Response::HTTP_CREATED
        );
    }
}
