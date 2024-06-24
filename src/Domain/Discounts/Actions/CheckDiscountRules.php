<?php

namespace Domain\Discounts\Actions;

use App\Api\Discounts\Exceptions\FailedDiscountRuleCheck;
use Domain\Discounts\Contracts\CanBeCheckedForDiscount;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\DiscountRule;
use Support\Enums\MatchAllAnyInt;

class CheckDiscountRules extends AbstractCheckDiscountEntityAction
{
    public CanBeCheckedForDiscount|Discount $discountEntity;

    public function handle(bool $throwOnFailure = true): bool
    {
        if (! $this->discountEntity->rules->count()) {
            throw new FailedDiscountRuleCheck(
                __('Discount has no rules')
            );
        }

        $this->discountEntity
            ->rules
            ->each(
                function (DiscountRule $rule) {
                    try {
                        $this->success = $this->check($rule);
                    } catch (\Exception $exception) {
                        if ($this->discountEntity->match_anyall === MatchAllAnyInt::ALL) {
                            throw $exception;
                        }

                        $this->catchToCollection($exception);
                    }
                }
            );

        if ($throwOnFailure && ! $this->success) {
            throw new \Exception(__('Discount failed rules check'));
        }

        return $this->success;
    }

    private function check(DiscountRule $rule): bool
    {
        return (new CheckDiscountRuleConditions(
            checkerData: $this->checkerData,
            discountEntity: $rule,
            cart: $this->cart,
            account: $this->account,
        ))
            ->handle();
    }
}
