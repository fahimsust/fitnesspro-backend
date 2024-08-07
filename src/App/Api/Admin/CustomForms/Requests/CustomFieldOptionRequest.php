<?php

namespace App\Api\Admin\CustomForms\Requests;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\FormSectionField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CustomFieldOptionRequest extends FormRequest
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
            'display' => ['string','max:255', 'required'],
            'value' => ['string','max:255', 'required'],
            'rank' => ['int', 'nullable'],
            'field_id' => ['numeric', 'exists:' . CustomField::Table() . ',id', 'required'],
        ];
    }
}
