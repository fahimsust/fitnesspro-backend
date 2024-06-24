<?php

namespace Domain\Products\Actions\Categories\Rules;

use Domain\Products\Models\Category\Rule\CategoryRule;
use Support\Contracts\AbstractAction;
use Support\Enums\MatchAllAnyString;

class UpdateCategoryRuleMatchType extends AbstractAction
{
    public function __construct(
        public CategoryRule      $rule,
        public MatchAllAnyString $matchType
    )
    {
    }

    public function execute(): CategoryRule
    {
        $this->rule->update([
            'match_type' => $this->matchType
        ]);

        return $this->rule;
    }
}
