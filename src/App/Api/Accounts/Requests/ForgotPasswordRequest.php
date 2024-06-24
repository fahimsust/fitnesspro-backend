<?php

namespace App\Api\Accounts\Requests;

use Domain\Accounts\Models\Account;

class ForgotPasswordRequest extends FindAccountByEmailRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:'.Account::Table()],
        ];
    }
}
