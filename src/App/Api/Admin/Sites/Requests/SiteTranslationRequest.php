<?php

namespace App\Api\Admin\Sites\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class SiteTranslationRequest extends FormRequest
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
            'meta_title' => ['string', 'max:255', 'required'],
            'meta_keywords' => ['string', 'max:255', 'required'],
            'meta_desc' => ['string', 'max:255', 'required'],
        ];
    }
}
