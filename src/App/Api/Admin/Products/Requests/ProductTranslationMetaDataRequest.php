<?php

namespace App\Api\Admin\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductTranslationMetaDataRequest extends FormRequest
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
            'meta_title' => ['string','max:155', 'nullable'],
            'meta_desc' => ['string','max:255', 'nullable'],
            'meta_keywords' => ['string','max:255', 'nullable'],
        ];
    }
}
