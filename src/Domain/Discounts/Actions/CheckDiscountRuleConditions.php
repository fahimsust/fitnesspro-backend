<?php

namespace Domain\Discounts\Actions;

use App\Api\Discounts\Exceptions\FailedDiscountRuleCheck;
use Domain\Discounts\Contracts\CanBeCheckedForDiscount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Support\Enums\MatchAllAnyInt;

class CheckDiscountRuleConditions extends AbstractCheckDiscountEntityAction
{
    public CanBeCheckedForDiscount|DiscountRule $discountEntity;

    public function handle(bool $throwOnFailure = true): bool
    {
        if (!$this->discountEntity->conditions->count()) {
            throw new FailedDiscountRuleCheck(
                __('Discount has no conditions'))
            ;
        }

        $this->discountEntity
            ->conditions
            ->each(
                function (DiscountCondition $condition) {
                    try {
                        $this->success = $this->check($condition);
                    } catch (\Exception $exception) {
                        if ($this->discountEntity->match_anyall === MatchAllAnyInt::ALL) {
                            throw $exception;
                        }

                        $this->catchToCollection($exception);
                    }
                }
            );

        if ($throwOnFailure && !$this->success) {
            throw new \Exception(__('Rule failed conditions check'));
        }

        return $this->success;
    }

    private function check(DiscountCondition $condition): bool
    {
        return (new CheckDiscountCondition(
            $this->checkerData,
            $condition,
            $this->cart,
            $this->account,
        ))
            ->execute();
    }
}
