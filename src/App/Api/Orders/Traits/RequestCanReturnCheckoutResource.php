<?php

namespace App\Api\Orders\Traits;

trait RequestCanReturnCheckoutResource
{
    public function rules()
    {
        return parent::rules()
            + [
                'include_payment_method' => ['sometimes', 'boolean'],
                'include_site' => ['sometimes', 'boolean'],
                'include_shipments' => ['sometimes', 'boolean'],
            ];
    }
}
