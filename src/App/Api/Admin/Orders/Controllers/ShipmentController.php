<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\CreateShipmentRequest;
use App\Api\Admin\Orders\Requests\UpdateShipmentRequest;
use Domain\Orders\Actions\Order\Shipment\AddShipment;
use Domain\Orders\Actions\Order\Shipment\DeleteShipment;
use Domain\Orders\Actions\Order\Shipment\UpdateShipment;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShipmentController extends AbstractController
{
    public function store(CreateShipmentRequest $request, Order $order)
    {
        return response(
            AddShipment::now($order, $request),
            Response::HTTP_CREATED
        );
    }

    public function update(
        Order                 $order,
        Shipment              $shipment,
        UpdateShipmentRequest $request
    ) {
        return response(
            UpdateShipment::now($shipment, $order, $request->validated()),
            Response::HTTP_CREATED
        );
    }
    public function destroy(Order $order, Shipment $shipment)
    {
        return response(
            DeleteShipment::now($shipment, $order, true),
            Response::HTTP_OK
        );
    }
}
