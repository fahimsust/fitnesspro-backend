<?php

namespace App\Api\Accounts\Requests\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Accounts\Models\Registration\RegistrationDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Foundation\Http\FormRequest;

class RemoveDiscountFromRegistrationRequest extends FormRequest
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
            'registration_discount_id' => ['integer', 'required', 'exists:' . CartDiscount::table() . ',id'],
        ];
    }
}
