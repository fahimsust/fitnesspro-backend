<?php

namespace App\Api\Accounts\Requests\Registration;

use Domain\Accounts\Models\AccountAddress;
use Illuminate\Foundation\Http\FormRequest;

class AccountAddressIdRequest extends FormRequest
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
            'address_id' => ['integer', 'required', 'exists:' . AccountAddress::table() . ',id'],
        ];
    }
}
