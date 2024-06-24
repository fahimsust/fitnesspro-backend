<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;

class SetCheckoutPaymentMethodRequest extends AbstractCheckoutRequest
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
                'payment_method_id' => ['required', 'integer', 'gt:0'],
            ]
            + parent::rules();
    }
}
