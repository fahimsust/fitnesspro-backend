<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Orders\Enums\Order\OrderStatuses;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderStatusController extends AbstractController
{
    public function index()
    {
        return response(
            OrderStatuses::options(),
            Response::HTTP_OK
        );
    }
}
