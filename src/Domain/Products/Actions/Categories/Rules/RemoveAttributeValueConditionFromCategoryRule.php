<?php

namespace Domain\Products\Actions\Categories\Rules;

use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class RemoveAttributeValueConditionFromCategoryRule extends AbstractAction
{
    public function __construct(
        public CategoryRule $rule,
        public int $conditionId,
    )
    {
    }

    public function execute(): void
    {
        $this->rule->categoryRuleAttributes()
            ->whereId($this->conditionId)
            ->delete();
    }
}
