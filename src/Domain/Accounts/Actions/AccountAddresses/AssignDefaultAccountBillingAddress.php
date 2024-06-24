<?php

namespace Domain\Accounts\Actions\AccountAddresses;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignDefaultAccountBillingAddress
{
    use AsObject;

    public function handle(
        Account $account,
        AccountAddress $accountAddress
    ): Account {
        $account->update([
            'default_billing_id' => $accountAddress->id,
        ]);

        $account->setRelation('defaultBillingAddress', $accountAddress);

        return $account;
    }
}
