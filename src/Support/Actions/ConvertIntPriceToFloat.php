<?php

namespace Support\Actions;

use Lorisleiva\Actions\Concerns\AsObject;

class ConvertIntPriceToFloat
{
    use AsObject;

    public function handle(int $price): float
    {
        return $price / 1_0000;
    }
}
