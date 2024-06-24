<?php

namespace Domain\Orders\Exceptions;

use Domain\Accounts\Models\Account;
use Exception;

class AccountNotAllowedCheckoutException extends Exception
{
    public static function check(Account $account)
    {
        if (!$account->membership_status) {
            throw new static('Account membership is not active');
        }


    }
}
