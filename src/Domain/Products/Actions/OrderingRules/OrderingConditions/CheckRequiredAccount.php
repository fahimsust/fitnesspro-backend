<?php

namespace Domain\Products\Actions\OrderingRules\OrderingConditions;

use Domain\Products\Contracts\AccountConditionCheck;

class CheckRequiredAccount extends AccountConditionCheck
{
    public function check(): bool
    {
        $this->checkUserIsLoggedIn();

        return true;
    }
}
