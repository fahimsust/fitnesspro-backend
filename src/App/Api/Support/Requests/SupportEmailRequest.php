<?php

namespace App\Api\Support\Requests;

use Domain\Support\Models\SupportDepartment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class SupportEmailRequest extends FormRequest
{
    use HasFactory;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string','required'],
            'email' => ['email','string','required'],
            'support_department_id' => ['integer', 'required', 'exists:' . SupportDepartment::table() . ',id'],
            'message' => ['string','required'],
            'origin' => ['string','required',Rule::in(['web', 'mobile'])],
        ];
    }
}
