<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\AccountConditionCheck;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveMembershipLevel extends AccountConditionCheck
{
    public function check(): bool
    {
        $this->checkUserIsLoggedIn();
        $this->checkUserHasActiveMembership();

        if ($this->checkUserMembershipLevelMatchesCondition()) {
            return true;
        }

        $this->failed(
            __('Membership level :current does not match :needed', [
                'current' => $this->accountsMembershipLevel(),
                'needed' => implode(', ', $this->requiredMembershipLevels()),
            ]),
            Response::HTTP_NOT_ACCEPTABLE
        );
    }

    private function accountsMembershipLevel(): int
    {
        return $this->account->activeMembership->level_id;
    }

    private function requiredMembershipLevels()
    {
        return $this->condition
            ->loadMissingReturn('membershipLevels')
            ->pluck('id')
            ->toArray();
    }

    protected function checkUserHasActiveMembership(): void
    {
        if (!$this->account->hasActiveMembership()) {
            $this->failed(
                __('Account does not have an active membership'),
                Response::HTTP_GONE
            );
        }
    }

    protected function checkUserMembershipLevelMatchesCondition(): bool
    {
        return in_array(
            $this->accountsMembershipLevel(),
            $this->requiredMembershipLevels()
        );
    }
}
