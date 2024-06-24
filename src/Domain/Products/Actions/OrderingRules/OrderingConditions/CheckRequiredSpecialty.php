<?php

namespace Domain\Products\Actions\OrderingRules\OrderingConditions;

use Domain\Accounts\Actions\Speciality\CheckAccountHasApprovedSpecialties;
use Domain\Products\Contracts\AccountConditionCheck;
use Support\Enums\MatchAllAnyInt;

class CheckRequiredSpecialty extends AccountConditionCheck
{
    public function check(): bool
    {
        $this->checkUserIsLoggedIn();

        if (! $this->condition->items->count()) {
            return true;
        }

        CheckAccountHasApprovedSpecialties::run(
            $this->account,
            $this->condition->specialties,
            $this->condition->any_all === 'all'
                ? MatchAllAnyInt::ALL
                : MatchAllAnyInt::ANY
        );

        return true;
    }
}
