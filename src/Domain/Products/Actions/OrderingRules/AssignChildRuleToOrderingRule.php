<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignChildRuleToOrderingRule
{
    use AsObject;

    public function handle(
        OrderingRule $orderingRule,
        int $childRuleId
    ) {
        if (CheckIfOrderingChildRuleExists::run($orderingRule, $childRuleId)) {
            throw new \Exception(__('Rule is already added as child rule'));
        }

        return $orderingRule->subRules()->create([
            'child_rule_id' => $childRuleId,
        ]);
    }
}
