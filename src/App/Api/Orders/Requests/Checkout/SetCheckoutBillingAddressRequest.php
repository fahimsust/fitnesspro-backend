<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;

class SetCheckoutBillingAddressRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete;

    public function rules()
    {
        return [
                'address_id' => ['required', 'integer', 'gt:0'],
            ]
            + parent::rules();
    }
}
