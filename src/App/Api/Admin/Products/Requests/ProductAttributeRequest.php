<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductAttributeRequest extends FormRequest
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
            'option_ids' => [
                'array',
                'nullable'
            ],
            'option_ids.*' => [
                'regex:/^[a-z0-9\s]*$/i',
                'nullable'
            ],
            'attribute_id' => [
                'int',
                'exists:' . Attribute::Table() . ',id',
                'required'
            ],
            'product_id' => [
                'int',
                'exists:' . Product::Table() . ',id',
                'required'
            ],

        ];
    }
}
