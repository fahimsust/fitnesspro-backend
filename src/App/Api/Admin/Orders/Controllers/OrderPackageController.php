<?php

namespace App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\UpdatePackageShipmentRequest;
use App\Http\Resources\LogMsgResource;
use Domain\Orders\Actions\Order\Package\DeleteOrderPackage;
use Domain\Orders\Actions\Order\Package\MovePackageToAnotherShipment;
use Domain\Orders\Actions\Order\Shipment\AddPackageToShipment;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderPackageController extends AbstractController
{
    public function store(Shipment $shipment)
    {
        return response(
            AddPackageToShipment::now($shipment)->createdPackage,
            Response::HTTP_CREATED
        );
    }

    public function destroy(Shipment $shipment, OrderPackage $orderPackage)
    {
        return response(
            new LogMsgResource(
                DeleteOrderPackage::now($orderPackage, $shipment, true)
            ),
            Response::HTTP_OK
        );
    }

    public function update(
        Shipment                     $shipment,
        OrderPackage                 $orderPackage,
        UpdatePackageShipmentRequest $request
    )
    {
        return response(
            new LogMsgResource(
                MovePackageToAnotherShipment::now(
                    $orderPackage,
                    $shipment,
                    Shipment::find($request->shipment_id)
                )
            ),
            Response::HTTP_OK
        );
    }
}
