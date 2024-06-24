<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestCanReturnCheckoutResource;
use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;

class RecoverCheckoutRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete,
        RequestCanReturnCheckoutResource;
}
