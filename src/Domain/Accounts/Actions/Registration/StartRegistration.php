<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Actions\CreateAccountFromBasicInfo;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Accounts\ValueObjects\BasicAccountInfoData;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;
use Support\Traits\ActionExecuteReturnsStatic;

class StartRegistration extends AbstractAction
{
    use ActionExecuteReturnsStatic;

    public Account $account;
    public Registration $registration;

    public function __construct(
        public Site                 $site,
        public BasicAccountInfoData $accountInfo,
        public ?int                 $registration_id
    )
    {
    }

    public function execute(): static
    {
        $account_id = null;

        $registration = Registration::find($this->registration_id);

        if ($registration) {
            $account_id = $registration->account_id;
        }

        $this->account = CreateAccountFromBasicInfo::run($this->accountInfo, $account_id);

        if ($registration) {
            $this->registration = $registration;
        } else {
            $this->registration = CreateRegistration::run(
                $this->site->id,
                $this->account
            );
        }

        return $this;
    }

    public function resource(): array
    {
        return [
            'account' => $this->account,
            'registration_id' => $this->registration->id,
        ];
    }
}
