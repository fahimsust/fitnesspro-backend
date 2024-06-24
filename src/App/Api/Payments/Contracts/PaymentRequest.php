<?php

namespace App\Api\Payments\Contracts;

use Illuminate\Foundation\Http\FormRequest;
use Support\Traits\RequestCanReturnOrderResource;

class PaymentRequest extends FormRequest
{
    use RequestCanReturnOrderResource;

    public function authorize()
    {
        return true;
    }
}
