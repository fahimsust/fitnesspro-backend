<?php

namespace App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Support\Traits\HasAccountEmailUserValidation;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateAccountFromBasicInfoRequest extends FormRequest
{
    use HasFactory, HasAccountEmailUserValidation;

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
            'username' => $this->getUsernameValidation(),
            'email' => $this->getEmailValidation(),
            'password' => ['max:60', 'min:8', 'confirmed', 'required', new PasswordRule()],
            'first_name' => ['string', 'max:55', 'required'],
            'last_name' => ['string', 'max:55', 'required'],
            'phone' => ['string', 'max:35', 'nullable'],
        ];
    }
}
