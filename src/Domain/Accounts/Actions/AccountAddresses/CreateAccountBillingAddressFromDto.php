<?php

namespace Domain\Accounts\Actions\AccountAddresses;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Dtos\AddressDto;

class CreateAccountBillingAddressFromDto
{
    use AsObject;

    public static function handle(
        Account $account,
        AddressDto $addressData
    ): AccountAddress {
        return AccountAddress::create(
            $addressData->b($account)
        );
    }
}
