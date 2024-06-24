<?php

namespace App\Api\Accounts\Requests\Membership;

use App\Api\Accounts\Rules\BlackListEmail;
use App\Api\Accounts\Rules\BlackListIP;
use Domain\Accounts\DataTransferObjects\RegisteringMemberData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\WithData;
use Worksome\RequestFactories\Concerns\HasFactory;

class NewMemberRequest extends FormRequest
{
    use WithData;
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

    public function rules()
    {
        return [
            'username' => $this->getUsernameValidation(),
            'email' => $this->getEmailValidation(),
            'password' => ['max:255', 'min:6', 'confirmed', 'required'],

            'first_name' => ['string', 'max:55', 'required'],
            'last_name' => ['string', 'max:55', 'required'],
            'specialties' => ['required', 'array'],
            'phone' => ['string','max:255','nullable'],
            'type_id' => ['numeric','nullable'],
            'affiliate_id' => ['numeric','nullable'],
            'cim_profile_id' => ['numeric','nullable'],
        ];
    }

    protected function dataClass(): string
    {
        return RegisteringMemberData::class;
    }

    private function useUsername(): bool
    {
        return config('accounts.account_use_username');
    }

    private function getUsernameValidation(): array
    {
        $validation = ['string', 'max:55', 'required'];

        if ($this->useUsername()) {
            $validation[] = 'unique:accounts,username';
        }

        return $validation;
    }

    private function getEmailValidation(): array
    {
        $validation = [
            'string',
            'email',
            'max:85',
            'required',
            'confirmed',
            new BlackListEmail(),
            new BlackListIP(),
        ];

        if (! $this->use_username || config('accounts.dont_allow_duplicate_email')) {
            $validation[] = 'unique:accounts';
        }

        return $validation;
    }
}
