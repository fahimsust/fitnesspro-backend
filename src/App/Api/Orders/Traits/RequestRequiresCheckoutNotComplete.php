<?php

namespace App\Api\Orders\Traits;

trait RequestRequiresCheckoutNotComplete
{
    public function authorize()
    {
        $this->validateCheckoutStatus();

        return parent::authorize();
    }
}
