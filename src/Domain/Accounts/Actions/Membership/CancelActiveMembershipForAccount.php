<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\Enums\SubscriptionStatus;
use Domain\Accounts\Models\Account;
use Lorisleiva\Actions\Concerns\AsObject;

class CancelActiveMembershipForAccount
{
    //@fahim - pls use AsObject for actions unless/until we know we're going to use it for other purposes
    use AsObject;

    public function handle(Account $account): bool
    {
        $membership = $account->activeMembership();

        if (! $membership) {
            return false;
        }

        //@fahim - usually i prefer this method for updating a model
        $membership->update([
            'status' => SubscriptionStatus::INACTIVE,
            'cancelled' => now(),
        ]);

        return true;
    }
}
