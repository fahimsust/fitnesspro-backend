<?php

namespace App\Api\Payments\Requests;

use App\Api\Payments\Contracts\PaymentRequest;

class CimPaymentProfileRequest extends PaymentRequest
{
    public function rules(): array
    {
        return [
            'payment_profile_id' => ['required', 'integer', 'gt:0'],
        ] + parent::rules();
    }
}
