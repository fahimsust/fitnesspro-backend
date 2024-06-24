<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConditionAttributeRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'attributevalue_id' => [
                'int',
                'exists:' . AttributeOption::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ConditionAttribute::Table(),
                    [
                        'attributevalue_id' => $this->attributevalue_id,
                        'condition_id' => $this->condition_id,
                    ],
                    $this->id
                ),
            ],
            'condition_id' => [
                'int',
                'exists:' . DiscountCondition::Table() . ',id',
                'required'
            ],
        ];
    }
}
