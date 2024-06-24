<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Dtos\Shipping\ShippingRateDto;
use Illuminate\Support\Collection;

class CalculatedShippingRatesCollection extends Collection
{
    public function offsetGet($key): ShippingRateDto
    {
        return parent::offsetGet($key);
    }
}
