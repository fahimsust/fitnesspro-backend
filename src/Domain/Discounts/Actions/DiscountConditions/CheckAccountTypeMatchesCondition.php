<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\AccountConditionCheck;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountTypeMatchesCondition extends AccountConditionCheck
{
    public function check(): bool
    {
        $this->checkUserIsLoggedIn();

        if (
            in_array(
                $this->account->type_id,
                $this->condition->loadMissingReturn('accountTypes')->pluck('id')->toArray()
            )
        ) {
            return true;
        }

        $this->failed(
            __('Account type :type does not match :required', [
                'type' => $this->account->type_id,
                'required' => $this->condition->accountTypes->pluck('id')->implode(', '),
            ]),
            Response::HTTP_NOT_ACCEPTABLE
        );
    }
}
