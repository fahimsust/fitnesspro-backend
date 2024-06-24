<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleSubRule;
use Illuminate\Database\Eloquent\Builder;

class OrderingRuleQuery extends Builder
{

    public function basicKeywordSearch(?string $keyword)
    {
        return $this->like(['id', 'name'], $keyword);
    }

    public function availableToAssignAsChild(OrderingRule $orderingRule, ?string $keyword)
    {
        return $this->basicKeywordSearch($keyword)
            ->where('id', '!=', $orderingRule->id)
            ->whereNotIn(
                'id',
                OrderingRuleSubRule::whereParentRuleId($orderingRule->id)
                    ->select('child_rule_id')
                    ->pluck('child_rule_id')
            );
    }
}
