<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;

class SetCheckoutShippingAddressRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'address_id' => ['required', 'integer', 'gt:0'],
                'set_as_billing' => ['required', 'boolean'],
            ]
            + parent::rules();
    }
}
