<?php

namespace App\Api\Payments\Requests;

use App\Api\Payments\Contracts\PaymentRequest;

class ConfirmPaymentRequest extends PaymentRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'order_transaction_id' => $this->route('order_transaction_id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'order_transaction_id' => ['required', 'integer', 'gt:0'],
        ] + parent::rules();
    }
}
