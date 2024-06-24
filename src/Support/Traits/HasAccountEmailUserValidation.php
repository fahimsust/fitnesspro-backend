<?php

namespace Support\Traits;

use App\Api\Accounts\Rules\BlackListEmail;
use App\Api\Accounts\Rules\BlackListIP;
use Domain\Accounts\Models\Registration\Registration;

trait HasAccountEmailUserValidation
{
    public function getUsernameValidation(): array
    {
        $validation = ['string', 'max:55', 'required'];

        if (config('accounts.account_use_username')) {
            $accountId = session('registrationId') ? $this->getAccountIdFromRegistration(session('registrationId')) : null;
            $uniqueRule = 'unique:accounts,username';
            $uniqueRule .= $accountId ? ',' . $accountId : '';
            $validation[] = $uniqueRule;
        }

        return $validation;
    }

    public function getEmailValidation(): array
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

        if (!config('accounts.account_use_username') || config('accounts.dont_allow_duplicate_email')) {
            $accountId = session('registrationId') ? $this->getAccountIdFromRegistration(session('registrationId')) : null;
            $uniqueRule = 'unique:accounts,email';
            $uniqueRule .= $accountId ? ',' . $accountId : '';
            $validation[] = $uniqueRule;
        }

        return $validation;
    }

    protected function getAccountIdFromRegistration($registrationId)
    {
        $registration = Registration::find($registrationId);
        return $registration ? $registration->account->id : null;
    }
}
