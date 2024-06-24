<?php

namespace Domain\Products\Actions\OrderingRules\OrderingConditions;

use Domain\Products\Contracts\AccountConditionCheck;

class CheckRequiredAccountType extends AccountConditionCheck
{
    public function check(): bool
    {
        $this->checkUserIsLoggedIn();

        if (! $this->condition->items->count()) {
            return true;
        }

        if ($this->condition->accountTypes
            ->pluck('id')
            ->doesntContain($this->account->type_id)) {
            throw new \Exception(__('Account does not match required account types'));
        }

        return true;
    }
}
