<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Accounts\Models\Account;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Contracts\AbstractAction;
use Support\Enums\MatchAllAnyString;
use Support\Traits\ActionExecuteReturnsStatic;
use Support\Traits\HasExceptionCollection;

class CheckOrderingRuleConditions extends AbstractAction
{
    use ActionExecuteReturnsStatic,
        HasExceptionCollection;

    public bool $passed = false;

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
        if (!$this->rule->hasConditions()) {
            return $this;
        }

        $this->rule->conditions
            ->each(
                function (OrderingCondition $condition) {
                    try {
                        (new CheckOrderingCondition(
                            $condition,
                            account: $this->account
                        ))->handle();

                        $this->passed = true;

                        if ($this->rule->any_all === MatchAllAnyString::ANY) {
                            return false;
                        }
                    } catch (\Exception $exception) {
                        if ($this->rule->any_all === MatchAllAnyString::ALL) {
                            throw $exception;
                        }

                        $this->catchToCollection($exception);
                    }
                }
            );

        return $this;
    }

    public function throwIfFailed()
    {
        if (!$this->passed) {
            throw new \Exception(
                __("Failed to meet condition(s) for ordering: \n:errors", [
                    'errors' => $this->exceptionsToPlainText(),
                ])
            );
        }
    }
}
