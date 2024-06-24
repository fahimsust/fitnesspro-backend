<?php

namespace Domain\Affiliates\Actions;

use Domain\Accounts\Models\Account;
use Domain\Affiliates\Models\Affiliate;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\AbstractAction;

class CreateAffiliateFromAccount extends AbstractAction
{
    public Affiliate $affiliate;

    public function __construct(public Account $account)
    {}

    public function execute(): Affiliate
    {
        if (!$this->account->default_billing_id || !$this->account->defaultBillingAddress) {
            throw new \Exception('Default billing address for account is not set');
        }

        $this->affiliate = Affiliate::create([
            'name' => $this->account->first_name . ' ' . $this->account->last_name,
            'email' => $this->account->email,
            'password' => $this->account->password,
            'affiliate_level_id' => $this->account->type->affiliate_level_id,
            'status' => 1,
            'account_id' => $this->account->id,
            'address_id' => $this->account->defaultBillingAddress->id,
        ]);

        return $this->affiliate;
    }
}
