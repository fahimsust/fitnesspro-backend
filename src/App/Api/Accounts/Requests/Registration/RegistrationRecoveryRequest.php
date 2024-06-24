<?php

namespace App\Api\Accounts\Requests\Registration;

use Domain\Accounts\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRecoveryRequest extends FormRequest
{
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
            'email' => [
                'email',
                'required',
                'exists:' . Account::table() . ',email',
            ],
        ];
    }
}
