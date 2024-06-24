<?php

namespace App\Api\Orders\Requests\Cart;

use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class AddItemToCartRequest extends FormRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //todo if require account for ordering, check here?
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required', 'int', 'exists:' . Product::Table() . ',id'],
            'qty' => ['required', 'int', 'min:1'],
            'custom_field_values' => ['nullable', 'array'],
            'option_custom_values' => ['nullable', 'array'],
            'accessories' => ['nullable', 'array'],
        ];
    }
}
