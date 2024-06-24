<?php

namespace App\Api\Admin\CustomForms\Requests;

use Domain\CustomForms\Models\CustomForm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class FormSectionRequest extends FormRequest
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
            'title' => ['string','max:155', 'required'],
            'rank' => ['int', 'required'],
            'form_id' => ['numeric', 'exists:' . CustomForm::Table() . ',id', 'required'],
        ];
    }
}
