<?php

namespace App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\Shipments\Shipment;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShipmentPrintController extends AbstractController
{
    public function show(int $shipment_id)
    {
        return response(
            Shipment::with([
                'packages' => function ($query) {
                    $query->orderBy('id', "asc");
                },
                'packages.items' => function ($query) {
                    $query->orderBy('id', "asc");
                },
                'packages.items.product',
                'packages.items.discounts',
                'packages.items.optionValues.optionValue',
                'packages.items.optionValues.optionValue.option',
                'order',
                'order.shippingAddress',
                'order.shippingAddress.stateProvince',
                'order.shippingAddress.country',
                'order.account'
            ])->find($shipment_id),
            Response::HTTP_OK
        );
    }
}
