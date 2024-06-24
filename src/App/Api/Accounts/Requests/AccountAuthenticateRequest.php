<?php

namespace App\Api\Accounts\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountAuthenticateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user' => ['required', 'max:55'],
            'pass' => ['required', 'max:35'],
        ];
    }
}
