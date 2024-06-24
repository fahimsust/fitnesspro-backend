<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Database\Eloquent\Model;

class SetCheckoutShipmentShipMethodRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete;

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge([
            'shipment_id' => $this->route('shipment_id'),
        ]);
    }

    public function rules()
    {
        return [
                'shipment_id' => ['required', 'integer', 'gt:0'],
                'method_id' => ['required', 'integer', 'gt:0'],
            ]
            + parent::rules();
    }

    public function loadShipment(): CheckoutShipment|Model
    {
        return $this->loadCheckoutByUuid()
            ->shipments()
            ->where('id', $this->shipment_id)
            ->first()
            ?? throw new \Exception('Shipment not found');
    }
}
