<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestCanReturnCheckoutResource;
use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;

class SetCheckoutAccountRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete,
        RequestCanReturnCheckoutResource;

    public function rules()
    {
        return [
                'account_id' => ['required', 'integer', 'gt:0'],
            ]
            + parent::rules();
    }
}
