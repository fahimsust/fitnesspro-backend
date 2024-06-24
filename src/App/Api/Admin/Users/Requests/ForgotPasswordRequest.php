<?php

namespace App\Api\Admin\Users\Requests;

use Domain\AdminUsers\Models\User;

class ForgotPasswordRequest extends FindUserByEmailRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:'.User::Table()],
        ];
    }
}
