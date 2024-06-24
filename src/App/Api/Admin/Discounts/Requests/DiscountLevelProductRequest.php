<?php

namespace App\Api\Admin\Discounts\Requests;

use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DiscountLevelProductRequest extends FormRequest
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
                'required'
            ],
        ];
    }
}
