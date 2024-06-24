<?php

namespace App\Api\Admin\Orders\Requests;

use Domain\Affiliates\Models\Affiliate;
use Domain\CustomForms\Models\CustomForm;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class OrderCustomFormRequest extends FormRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'form_id' => ['int', 'exists:' . CustomForm::Table() . ',id', 'required'],
            'product_id' => ['int', 'exists:' . Product::Table() . ',id', 'nullable'],
            'product_type_id' => ['int', 'exists:' . ProductType::Table() . ',id', 'nullable'],
            'form_values' => ['array', 'required']
        ];
    }
}
