<?php

namespace App\Api\Accounts\Requests\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Foundation\Http\FormRequest;

class ApplyDiscountCodeToRegistrationRequest extends FormRequest
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
            'discount_code' => ['string', 'required', 'exists:' . DiscountCondition::table() . ',required_code'],
        ];
    }
}