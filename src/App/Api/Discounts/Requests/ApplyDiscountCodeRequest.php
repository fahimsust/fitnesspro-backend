<?php

namespace App\Api\Discounts\Requests;

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class ApplyDiscountCodeRequest extends FormRequest
{
    use HasFactory;

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
     * @return array
     */
    public function rules()
    {
        return [
            'discount_code' => ['required', 'string', 'exists:' . DiscountCondition::Table() . ',required_code'],
        ];
    }
}
