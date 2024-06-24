<?php

namespace App\Api\Admin\ProductOptions\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CustomFieldOptionValueRequest extends FormRequest
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
            'custom_type' => ['numeric', 'required'],
            'custom_charlimit' => ['numeric', 'required'],
            'custom_label' => ['string', 'max:35', 'required'],
            'custom_instruction' => ['string', 'max:255', 'required'],
        ];
    }
}
