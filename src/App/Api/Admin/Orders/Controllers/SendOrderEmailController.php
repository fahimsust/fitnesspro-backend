<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Accounts\Jobs\Membership\SendSiteMailable;
use Domain\Orders\Mail\OrderPlaced;
use Domain\Orders\Models\Order\Order;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SendOrderEmailController extends AbstractController
{
    public function __invoke(Order $order)
    {
        SendSiteMailable::dispatch(
            $order->siteCached(),
            (new OrderPlaced($order->account))
                ->order($order)
        );
        return response(
            "Success",
            Response::HTTP_OK
        );
    }
}
