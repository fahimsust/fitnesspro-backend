<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestCanReturnCheckoutResource;

class SetCheckoutCommentsRequest extends AbstractCheckoutRequest
{
    use RequestCanReturnCheckoutResource;

    public function rules()
    {
        return parent::rules()
            + [
                'comments' => ['required', 'string'],
            ];
    }
}
