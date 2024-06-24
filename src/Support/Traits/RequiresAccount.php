<?php

namespace Support\Traits;

use Domain\Accounts\Models\Account;

trait RequiresAccount
{
    public Account $account;

    public function account(Account $account): static
    {
        $this->account = $account;

        return $this;
    }
}
