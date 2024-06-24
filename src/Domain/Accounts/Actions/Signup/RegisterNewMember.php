<?php

namespace Domain\Accounts\Actions\Signup;

use Domain\Accounts\Actions\Membership\CreateMembershipFromNewMemberData;
use Domain\Accounts\DataTransferObjects\RegisteringMemberData;
use Domain\Accounts\Jobs\EmailAdminOnCreation;
use Domain\Accounts\Jobs\EmailCustomerOnCreation;
use Domain\Accounts\Jobs\SendVerificationEmailOnCreation;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Dtos\AddressDto;

class RegisterNewMember
{
    use AsObject;

    public function handle(RegisteringMemberData $dto, AddressDto $addressData)
    {
        //create account
        $account = CreateAccountFromNewMemberData::run($dto, $addressData);
        //create membership
        CreateMembershipFromNewMemberData::run($account, $dto);
        //dispatch jobs to send emails: to admin, to user, to verify email
        dispatch(new EmailAdminOnCreation($account));
        dispatch(new EmailCustomerOnCreation($account));
        dispatch(new SendVerificationEmailOnCreation($account));
    }
}
