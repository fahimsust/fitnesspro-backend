<?php

namespace App\Api\Admin\CustomForms\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class FormTranslationRequest extends FormRequest
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
            'name' => ['string','max:100', 'required'],
        ];
    }
}
