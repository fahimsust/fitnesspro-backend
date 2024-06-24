<?php

namespace App\Api\Accounts\Exceptions;

use function __;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountAddress
{
    public function __construct(
        public AccountAddress $accountAddress
    ) {
    }

    public function belongsTo(
        Account $account
    ) {
        if ($this->accountAddress->account_id === $account->id) {
            return;
        }

        throw new \Exception(
            __('Address does not belong to that account'),
            Response::HTTP_FORBIDDEN
        );
    }
}
