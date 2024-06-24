<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Exceptions\AccountNotFoundException;
use Domain\Accounts\Models\Account;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadAccountByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $accountId,
    )
    {
    }

    public function execute(): Account
    {
        return Cache::tags([
            "account-cache.{$this->accountId}",
        ])
            ->remember(
                'load-account-by-id.' . $this->accountId,
                60 * 5,
                fn() => Account::find($this->accountId)
                    ?? throw new AccountNotFoundException(
                        __("No account matching ID {$this->accountId}.")
                    )
            );
    }
}
