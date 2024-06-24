<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConditionProductRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'product_id' => [
                'int',
                'exists:' . Product::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ConditionProduct::Table(),
                    [
                        'product_id' => $this->product_id,
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
