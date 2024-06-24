<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;
use Domain\Orders\Dtos\CheckoutShipmentIdWithMethod;
use Illuminate\Support\Collection;

class SetCheckoutShipmentsShipMethodsRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete;

    public function rules()
    {
        return [
                'shipments' => ['required', 'array'],
                'shipments.*.id' => ['required', 'integer', 'gt:0'],
                'shipments.*.method_id' => ['required', 'integer', 'gt:0'],
            ]
            + parent::rules();
    }

    public function buildCollection(): Collection
    {
        return collect($this->shipments)
            ->map(
                fn(array $shipment) => new CheckoutShipmentIdWithMethod(
                    checkoutShipmentId: $shipment['id'],
                    methodId: $shipment['method_id'],
                )
            );
    }
}
