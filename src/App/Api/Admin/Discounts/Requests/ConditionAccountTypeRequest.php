<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Accounts\Models\AccountType;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConditionAccountTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'accounttype_id' => [
                'int',
                'exists:' . AccountType::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ConditionAccountType::Table(),
                    [
                        'accounttype_id' => $this->accounttype_id,
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
