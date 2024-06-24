<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderAffiliateController extends AbstractController
{
    public function __invoke(Order $order)
    {
        return response(
            $order->update([
                "affiliate_id"=> null,
            ]),
            Response::HTTP_OK
        );
    }
}
