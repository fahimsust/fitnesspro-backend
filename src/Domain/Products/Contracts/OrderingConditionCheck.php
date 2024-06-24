<?php

namespace Domain\Products\Contracts;

use Domain\Products\Exceptions\ConditionCheckFailed;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Lorisleiva\Actions\Concerns\AsObject;

abstract class OrderingConditionCheck
{
    use AsObject;

    public function __construct(
        public OrderingCondition $condition
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
