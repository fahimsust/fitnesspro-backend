<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestCanReturnCheckoutResource;

class GetCheckoutRequest extends AbstractCheckoutRequest
{
    use RequestCanReturnCheckoutResource;
}
