<?php

namespace App\Api\Admin\Sites\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateSiteRequest extends FormRequest
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
            'name' => ['string','max:55', 'required'],
            'domain' => ['string', 'max:65', 'nullable'],
            'email' => ['email', 'max:85', 'required'],
            'phone' => ['string', 'max:20', 'required'],
            'url' => ['string', 'max:255', 'required'],
            'meta_title' => ['string', 'max:255', 'required'],
            'meta_keywords' => ['string', 'max:255', 'required'],
            'meta_desc' => ['string', 'max:255', 'required'],
            'logo_url' => ['string', 'max:255', 'nullable'],
        ];
    }
}
