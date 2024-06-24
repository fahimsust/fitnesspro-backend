<?php

namespace Domain\Products\Actions\Categories\Rules;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;
use Support\Enums\MatchAllAnyString;

class DeleteCategoryRule extends AbstractAction
{
    public function __construct(
        public CategoryRule      $rule,
    )
    {
    }

    public function execute(): void
    {
        $this->rule->categoryRuleAttributes()->delete();
        $this->rule->delete();
    }
}
