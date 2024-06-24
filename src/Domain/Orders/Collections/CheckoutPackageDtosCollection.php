<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Dtos\CheckoutPackageDto;
use Illuminate\Support\Collection;

class CheckoutPackageDtosCollection extends Collection
{
    public function offsetGet($key): CheckoutPackageDto
    {
        return parent::offsetGet($key);
    }
}
