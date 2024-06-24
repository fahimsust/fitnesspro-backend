<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdvantageProductTypeRequest extends FormRequest
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
                    AdvantageProductType::Table(),
                    [
                        'producttype_id' => $this->producttype_id,
                        'advantage_id' => $this->advantage_id,
                    ],
                    $this->id
                ),
            ],
            'advantage_id' => [
                'int',
                'exists:' . DiscountAdvantage::Table() . ',id',
                'required'
            ],
        ];
    }
}
