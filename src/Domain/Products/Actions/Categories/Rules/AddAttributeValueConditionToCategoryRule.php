<?php

namespace Domain\Products\Actions\Categories\Rules;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class AddAttributeValueConditionToCategoryRule extends AbstractAction
{
    public function __construct(
        public CategoryRule $rule,
        public int $value_id,
        public int $set_id,
        public bool $matches = true,
    )
    {
    }

    public function execute(): CategoryRuleAttribute|Model
    {
        return $this->rule->categoryRuleAttributes()->create([
            'matches'=> $this->matches,
            'value_id'=> $this->value_id,
            'set_id'=> $this->set_id
        ]);
    }
}
