<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Models\Account;
use Support\Contracts\AbstractAction;

class UpdateAccountStatus extends AbstractAction
{
    public function __construct(
        public Account $account,
        public int $status_id,
    ) {
    }

    public function execute(): void
    {
        $this->account->update(
            [
                'status_id' => $this->status_id
            ]
        );
    }
}
