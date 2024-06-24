<?php

namespace App\Api\Admin\Sites\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class SettingsForSiteRequest extends FormRequest
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
            'home_show_categories_in_body' => ['boolean','required'],
            'home_feature_show' => ['boolean','required'],
            'catalog_show_categories_in_body' => ['boolean','required'],
            'catalog_feature_show' => ['boolean','required'],
            'default_show_categories_in_body' => ['boolean','required'],
        ];
    }
}
