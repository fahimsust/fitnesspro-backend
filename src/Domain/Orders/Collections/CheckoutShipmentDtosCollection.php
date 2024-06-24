<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Dtos\CheckoutShipmentDto;
use Illuminate\Support\Collection;

class CheckoutShipmentDtosCollection extends Collection
{
    public function offsetGet($key): CheckoutShipmentDto
    {
        return parent::offsetGet($key);
    }
}
