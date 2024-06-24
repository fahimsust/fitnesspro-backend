<?php

namespace App\Api\Orders\Requests\Checkout;

use App\Api\Orders\Traits\RequestRequiresCheckoutNotComplete;
use Support\Traits\RequestCanReturnOrderResource;

class CompleteCheckoutRequest extends AbstractCheckoutRequest
{
    use RequestRequiresCheckoutNotComplete,
        RequestCanReturnOrderResource;
}
