<?php

namespace App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Rules\IsValidSubscriptionPaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationPaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment_method_id' => ['integer', 'required', new IsValidSubscriptionPaymentMethod()],
        ];
    }
}
