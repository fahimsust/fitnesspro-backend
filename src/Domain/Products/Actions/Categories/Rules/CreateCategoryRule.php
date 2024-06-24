<?php

namespace Domain\Products\Actions\Categories\Rules;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;
use Support\Enums\MatchAllAnyString;

class CreateCategoryRule extends AbstractAction
{
    public function __construct(
        public Category          $category,
        public MatchAllAnyString $matchType
    )
    {
    }

    public function execute(): CategoryRule|Model
    {
        return $this->category->rules()->create([
            'match_type' => $this->matchType
        ]);
    }
}
