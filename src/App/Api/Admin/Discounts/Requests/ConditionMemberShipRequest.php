<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConditionMemberShipRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'membershiplevel_id' => [
                'int',
                'exists:' . MembershipLevel::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ConditionMembershipLevel::Table(),
                    [
                        'membershiplevel_id' => $this->membershiplevel_id,
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
