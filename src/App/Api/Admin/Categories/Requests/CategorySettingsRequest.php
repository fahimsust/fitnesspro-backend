<?php

namespace App\Api\Admin\Categories\Requests;

use Domain\Products\Models\Category\CategorySettingsTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategorySettingsRequest extends FormRequest
{
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
            'settings_template_id' => ['int', 'exists:' . CategorySettingsTemplate::Table() . ',id', 'nullable'],
        ];
    }
}
