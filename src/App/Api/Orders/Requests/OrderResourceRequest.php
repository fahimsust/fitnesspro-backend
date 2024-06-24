<?php

namespace App\Api\Orders\Requests;

use App\Api\Orders\Requests\Checkout\AbstractCheckoutRequest;
use Support\Traits\RequestCanReturnOrderResource;

class OrderResourceRequest extends AbstractCheckoutRequest
{
    use RequestCanReturnOrderResource;
}
