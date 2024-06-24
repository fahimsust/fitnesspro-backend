<?php

namespace App\Api\Admin\Discounts\Requests;

use Domain\Discounts\Enums\DiscountConditionRequiredQtyTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Worksome\RequestFactories\Concerns\HasFactory;

class DiscountConditionUpdateRequest extends FormRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'required_cart_value' => ['numeric', 'nullable'],
            'required_code' => ['string', 'max:25', 'nullable'],
            'required_qty_type' => [
                'int',
                new Enum(DiscountConditionRequiredQtyTypes::class),
                'nullable'
            ],
            'required_qty_combined' => ['numeric', 'nullable'],
            'match_anyall' => ['boolean', 'nullable'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'rank' => ['numeric', 'nullable'],
            'equals_notequals' => ['boolean', 'nullable'],
            'use_with_rules_products' => ['boolean', 'nullable'],
        ];
    }
    public function withValidator($validator)
    {
        $validator->sometimes('end_date', 'after_or_equal:start_date', function ($input) {
            return !is_null($input->start_date) && !is_null($input->end_date);
        });
    }
}
