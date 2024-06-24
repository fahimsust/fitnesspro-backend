<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveChildRuleFromOrderingRule
{
    use AsObject;

    public function handle(
        OrderingRule $orderingRule,
        int $childRuleId
    ) {
        if (! CheckIfOrderingChildRuleExists::run($orderingRule, $childRuleId)) {
            throw new \Exception(__('Rule is not added as child rule'));
        }

        $orderingRule->subRules()->whereChildRuleId($childRuleId)->delete();
    }
}
