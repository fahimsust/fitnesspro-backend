<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestCanReturnCheckoutResource;

class CreateOrderForCheckoutRequest extends AbstractCheckoutRequest
{
    use RequestCanReturnCheckoutResource;
}
