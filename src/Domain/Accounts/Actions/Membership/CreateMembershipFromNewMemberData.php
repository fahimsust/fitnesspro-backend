<?php

namespace Domain\Accounts\Actions\Membership;

use Domain\Accounts\DataTransferObjects\RegisteringMemberData;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\AbstractAction;

class CreateMembershipFromNewMemberData extends AbstractAction
{
    public function __construct(
        public Account $account,
        public RegisteringMemberData $dto
    )
    {
    }

    public function execute(): Subscription
    {
        CancelActiveMembershipForAccount::run($this->account);

        return CreateMembership::run(
            $this->account,
            $this->dto->subscriptionArray()
        );
    }
}
