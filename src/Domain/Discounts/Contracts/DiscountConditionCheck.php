<?php

namespace Domain\Discounts\Contracts;

use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Exceptions\ConditionCheckFailed;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Lorisleiva\Actions\Concerns\AsObject;

abstract class DiscountConditionCheck
{
    use AsObject;

    public function __construct(
        public DiscountCheckerData $checkerData,
        public DiscountCondition $condition
    ) {
    }

    public function handle(bool $throwOnFailure = true): bool
    {
        try {
            return $this->check();
        } catch (ConditionCheckFailed $checkFailed) {
            if ($throwOnFailure) {
                throw $checkFailed;
            }
        }

        return false;
    }

    abstract public function check(): bool;

    protected function failed(string $msg, int $code)
    {
        throw new ConditionCheckFailed($msg, $code);
    }
}
