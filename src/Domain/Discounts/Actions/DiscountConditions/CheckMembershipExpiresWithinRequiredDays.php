<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\AccountConditionCheck;
use Symfony\Component\HttpFoundation\Response;

class CheckMembershipExpiresWithinRequiredDays extends AccountConditionCheck
{
    public function check(): bool
    {
        $this->checkUserIsLoggedIn();
        $this->checkUserHasActiveMembership();

        if ($this->daysUntilActiveMembershipsExpiration() <= $this->conditionDays()) {
            return true;
        }

        $this->failed(
            __('Membership expires in :expire day(s), which is greater then :required', [
                'expire' => $this->daysUntilActiveMembershipsExpiration(),
                'required' => $this->conditionDays(),
            ]),
            Response::HTTP_NOT_ACCEPTABLE
        );
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

    protected function conditionDays(): string
    {
        return $this->condition->required_code;
    }

    protected function daysUntilActiveMembershipsExpiration()
    {
        return $this->account->activeMembership
            ->daysUntilExpiration();
    }
}
