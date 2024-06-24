<?php

namespace Domain\Accounts\Actions\Addresses;

use Domain\Accounts\DataTransferObjects\AccountAddressDto;
use Domain\Accounts\Models\AccountAddress;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAccountAddressFromAccountAddressData
{
    use AsObject;

    public function handle(
        AccountAddressDto $accountAddressData,
    ): AccountAddress {
        return AccountAddress::create(
            $accountAddressData->toModelArray()
        );
    }
}
