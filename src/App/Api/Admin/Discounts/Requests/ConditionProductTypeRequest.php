<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Discounts\Models\Rule\Condition\ConditionProductType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConditionProductTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'producttype_id' => [
                'int',
                'exists:' . ProductType::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ConditionProductType::Table(),
                    [
                        'producttype_id' => $this->producttype_id,
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
