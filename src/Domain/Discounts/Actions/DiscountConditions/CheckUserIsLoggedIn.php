<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\AccountConditionCheck;

class CheckUserIsLoggedIn extends AccountConditionCheck
{
    public function check(): bool
    {
        $this->checkUserIsLoggedIn();

        return true;
    }
}
