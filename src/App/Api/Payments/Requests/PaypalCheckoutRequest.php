<?php

namespace App\Api\Payments\Requests;

use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentInitiators;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentTypes;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentUsages;
use Illuminate\Validation\Rule;

class PaypalCheckoutRequest extends PaymentRequest
{
    public function rules(): array
    {
        return parent::rules();
    }
}
