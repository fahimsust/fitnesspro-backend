<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductAccessoryRequest extends FormRequest
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
            'accessory_id' => [
                'int',
                'exists:' . Product::Table() . ',id',
                'required'
            ],
            'required' => ['bool', 'nullable'],
            'show_as_option' => ['bool', 'nullable'],
            'discount_percentage' => ['integer','max:100','min:0', 'nullable'],
            'link_actions' => ['bool', 'nullable'],
            'description' => ['string', 'max:255', 'nullable'],
        ];
    }
}
