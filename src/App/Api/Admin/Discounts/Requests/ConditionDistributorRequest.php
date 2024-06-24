<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Discounts\Models\Rule\Condition\ConditionDistributor;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Distributors\Models\Distributor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConditionDistributorRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'distributor_id' => [
                'int',
                'exists:' . Distributor::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ConditionDistributor::Table(),
                    [
                        'condition_id' => $this->condition_id,
                        'distributor_id' => $this->distributor_id,
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
