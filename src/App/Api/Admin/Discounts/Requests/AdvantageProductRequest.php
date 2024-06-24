<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdvantageProductRequest extends FormRequest
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
                    AdvantageProduct::Table(),
                    [
                        'product_id' => $this->product_id,
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
