<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShipmentStatusController extends AbstractController
{
    public function index()
    {
        return response(
            ShipmentStatus::all(),
            Response::HTTP_OK
        );
    }
}
