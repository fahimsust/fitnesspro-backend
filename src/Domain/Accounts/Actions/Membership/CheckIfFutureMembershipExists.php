<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\Models\Account;
use Support\Contracts\AbstractAction;

class CheckIfFutureMembershipExists extends AbstractAction
{
    private bool $exists = false;

    public function __construct(
        public Account $account
    )
    {
    }

    public function execute(): static
    {
        $this->account->loadMissing('activeMembership');

        $this->exists = $this->account
            ->memberships()
            ->where(
                'level_id',
                $this->account->activeMembership->level_id
            )
            ->where(
                'start_date',
                ">",
                $this->account->activeMembership->end_date
            )
            ->where('status', true)
            ->exists();

        return $this;
    }

    public function result(): bool
    {
        return $this->exists;
    }
}
