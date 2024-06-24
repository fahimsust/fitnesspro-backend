<?php

namespace Domain\Accounts\Actions\Addresses;

use Domain\Accounts\DataTransferObjects\AccountAddressDto;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateDefaultBillingAddressForAccount
{
    use AsObject;

    public function handle(
        Account $account,
        AccountAddressDto $accountAddressData
    ): AccountAddress {
        $accountAddressData->setAccount($account);

        $accountAddress = CreateBillingAddressFromAccountAddressData::run(
            $accountAddressData
        );

        $account->update([
            'default_billing_id' => $accountAddress->id,
        ]);

        $account->setRelation('defaultBillingAddress', $accountAddress->address);

        return $accountAddress;
    }
}
