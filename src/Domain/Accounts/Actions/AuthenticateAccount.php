<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Exceptions\AccountLoginException;
use Domain\Accounts\Models\Account;
use Illuminate\Support\Facades\Hash;

class AuthenticateAccount
{
    public static function ByUser($user, $pass)
    {
        $account = Account::whereUsername($user)->first();

        if (is_null($account)) {
            throw new AccountLoginException(__('User not found'));
        }

        if (! Hash::check($pass, $account->password)) {
            throw new AccountLoginException(__('Invalid login credentials'));
        }

        return $account
            ->isActiveOrThrow()
            ->updateLastLogin();
    }
}
