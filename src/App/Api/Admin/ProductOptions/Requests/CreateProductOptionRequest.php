<?php

namespace App\Api\Admin\ProductOptions\Requests;

use App\Api\Admin\ProductOptions\Rules\IsParentProduct;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateProductOptionRequest extends FormRequest
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
            'name' => ['string', 'max:100', 'required'],
            'display' => ['string', 'max:100', 'required'],
            'type_id' => [
                'numeric',
                new Enum(ProductOptionTypes::class),
                'required'
            ],
            'product_id' => [
                'numeric',
                'exists:' . Product::Table() . ',id',
                new IsParentProduct,
                'required'
            ],
        ];
    }
}
