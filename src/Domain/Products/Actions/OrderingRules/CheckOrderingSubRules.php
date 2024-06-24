<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Accounts\Models\Account;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Contracts\AbstractAction;
use Support\Traits\HasExceptionCollection;
use Support\Traits\ActionExecuteReturnsStatic;

class CheckOrderingSubRules extends AbstractAction
{
    use HasExceptionCollection,
        ActionExecuteReturnsStatic;

    private bool $passed = false;

    public function __construct(
        private OrderingRule $rule,
        private ?Account     $account
    )
    {
    }

    public function result(): bool
    {
        return $this->passed;
    }

    public function execute(): static
    {
        if (!$this->rule->hasSubRules()) {
            $this->passed = true;

            return $this;
        }

        $this->rule->subRules
            ->each(
                fn(OrderingRule $rule) => $this->checkSubRule($rule)
            );

        return $this;
    }

    private function checkSubRule(OrderingRule $rule): void
    {
        try {
            CheckOrderingRule::run($rule, $this->account)
                ->throwIfFailed();

            $this->passed = true;
        } catch (\Exception $exception) {
            if ($this->rule->any_all === 'all') {
                throw $exception;
            }

            $this->catchToCollection($exception);
        }
    }
}
