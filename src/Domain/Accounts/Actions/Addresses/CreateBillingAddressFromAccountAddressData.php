<?php

namespace Domain\Accounts\Actions\Addresses;

use Domain\Accounts\DataTransferObjects\AccountAddressDto;
use Domain\Accounts\Models\AccountAddress;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateBillingAddressFromAccountAddressData
{
    use AsObject;

    public function handle(AccountAddressDto $accountAddressData): AccountAddress
    {
        $accountAddressData->is_billing = true;
        $accountAddressData->is_shipping = false;
        if (! $accountAddressData->label) {
            $accountAddressData->label = __('New Account Billing Address');
        }

        return CreateAccountAddressFromAccountAddressData::run($accountAddressData);
    }
}
