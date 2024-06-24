<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleSubRule;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckIfOrderingChildRuleExists
{
    use AsObject;

    public function handle(
        OrderingRule $orderingRule,
        int $childRuleId
    ): ?OrderingRuleSubRule {
        return $orderingRule->subRules()
            ->whereChildRuleId($childRuleId)
            ->first();
    }
}
