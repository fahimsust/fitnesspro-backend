<?php

namespace App\Api\Payments\Requests;

use App\Api\Payments\Contracts\PaymentRequest;

class PassivePaymentRequest extends PaymentRequest
{
    public function rules(): array
    {
        return parent::rules();
    }
}
