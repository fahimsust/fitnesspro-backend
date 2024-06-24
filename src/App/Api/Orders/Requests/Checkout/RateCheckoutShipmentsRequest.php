<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;

class RateCheckoutShipmentsRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete;
}
