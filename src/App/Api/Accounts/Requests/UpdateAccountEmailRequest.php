<?php

namespace App\Api\Accounts\Requests;

use Domain\Accounts\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountEmailRequest extends FormRequest
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
            'new_email' => ['email:rfc,dns,filter,spoof,strict', 'unique:'.Account::class.',email', 'required'],
        ];
    }
}
