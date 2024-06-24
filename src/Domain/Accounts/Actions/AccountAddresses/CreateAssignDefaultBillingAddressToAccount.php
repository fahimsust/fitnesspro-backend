<?php

namespace Domain\Accounts\Actions\AccountAddresses;

use Domain\Accounts\Actions\Addresses\CreateDefaultBillingAddressForAccount;
use Domain\Accounts\DataTransferObjects\AccountAddressDto;
use Domain\Accounts\Models\Account;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAssignDefaultBillingAddressToAccount
{
    use AsObject;

    public function handle(
        Account $account,
        AccountAddressDto $addressData
    ): Account {
        return AssignDefaultAccountBillingAddress::run(
            $account,
            CreateDefaultBillingAddressForAccount::run($account, $addressData)
        );
    }
}
