<?php

namespace Domain\Accounts\Actions\Signup;

use Domain\Accounts\Actions\AccountAddresses\CreateAssignDefaultBillingAddressToAccount;
use Domain\Accounts\Actions\Specialty\UpdateAccountsSpecialties;
use Domain\Accounts\DataTransferObjects\RegisteringMemberData;
use Domain\Accounts\Events\AccountCreated;
use Domain\Accounts\Models\Account;
use Domain\Affiliates\Actions\CreateAffiliateFromAccount;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Dtos\AddressDto;

class CreateAccountFromNewMemberData
{
    use AsObject;

    public Account $account;

    public function handle(RegisteringMemberData $dto, AddressDto $addressData): Account
    {
        $this->account = Account::create(
            $dto->accountArray()
        );

        CreateAssignDefaultBillingAddressToAccount::run($this->account, $addressData);

        if ($dto->accountType()->use_specialties) {
            UpdateAccountsSpecialties::run(
                $dto->specialties,
                $this->account,
                config('specialties.specialties_approved_onsignup')
            );
        }

        if (config('accounts.account_link_affiliate')) {
            CreateAffiliateFromAccount::run($this->account);
        }

        event(new AccountCreated($this->account));

        return $this->account;
    }
}
