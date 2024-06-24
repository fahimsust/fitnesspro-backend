<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Registration\Registration;
use Support\Contracts\AbstractAction;

class CreateRegistration extends AbstractAction
{
    public function __construct(
        public int     $siteId,
        public Account $account,
    )
    {
    }

    public function execute(): Registration
    {
        return Registration::create([
            'site_id' => $this->siteId,
            'account_id' => $this->account->id,
            'affiliate_id' => $this->account->affiliate_id,
        ]);
    }
}
