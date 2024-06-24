<?php

namespace App\Api\Admin\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductAddToCartSettingsRequest extends FormRequest
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
            'addtocart_external_label' => ['string','max:255', 'nullable'],
            'addtocart_external_link' => ['string','max:255', 'nullable'],
            'addtocart_setting' => ['int',Rule::in(['0','1','2']), 'nullable'],
        ];
    }
}
