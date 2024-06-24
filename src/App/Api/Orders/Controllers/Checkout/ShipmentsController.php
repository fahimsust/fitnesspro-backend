<?php

namespace App\Api\Orders\Controllers\Checkout;

use App\Api\Orders\Requests\Checkout\RateCheckoutShipmentsRequest;
use App\Api\Orders\Requests\Checkout\SetCheckoutShipmentShipMethodRequest;
use App\Api\Orders\Requests\Checkout\SetCheckoutShipmentsShipMethodsRequest;
use App\Api\Orders\Resources\Checkout\ShipmentDtoResource;
use Domain\Orders\Actions\Checkout\Shipment\SaveAndRateShipmentsForCheckout;
use Domain\Orders\Actions\Checkout\Shipment\SetCheckoutShipmentShipMethod;
use Domain\Orders\Actions\Checkout\Shipment\SetCheckoutShipmentsShipMethods;
use Domain\Orders\Dtos\CheckoutShipmentDto;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Support\Controllers\AbstractController;

class ShipmentsController extends AbstractController
{
    public function index(RateCheckoutShipmentsRequest $request)
    {
        return [
            'shipments' => ShipmentDtoResource::collection(
                SaveAndRateShipmentsForCheckout::now(
                    $request->loadCheckoutByUuid()
                )
            ),
        ];
    }

    public function store(SetCheckoutShipmentsShipMethodsRequest $request)
    {
        return [
            'shipments' => ShipmentDtoResource::collection(
                SetCheckoutShipmentsShipMethods::now(
                    $request->loadCheckoutByUuid(),
                    $request->buildCollection()
                )->map(
                    fn(CheckoutShipment $shipment) => CheckoutShipmentDto::fromCheckoutShipmentModel(
                        $shipment
                    )
                )
            ),
        ];
    }

    public function update(SetCheckoutShipmentShipMethodRequest $request)
    {
        return [
            'shipment' => new ShipmentDtoResource(
                CheckoutShipmentDto::fromCheckoutShipmentModel(
                    SetCheckoutShipmentShipMethod::now(
                        $request->loadShipment(),
                        $request->method_id,
                    )
                )
            )
        ];
    }
}
