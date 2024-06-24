<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Models\Account;
use Support\Contracts\AbstractAction;

class UpdateAccountType extends AbstractAction
{
    public function __construct(
        public Account $account,
        public int $account_type_id,
    ) {
    }

    public function execute(): void
    {
        $this->account->update(
            [
                'type_id' => $this->account_type_id
            ]
        );
    }
}
