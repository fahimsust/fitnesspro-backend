<?php

namespace Domain\Products\QueryBuilders;

use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttributeOptionQuery extends Builder
{
    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'display'], $keyword);
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('condition_id')) {
            $option_ids = ConditionAttribute::whereConditionId($request->condition_id)->pluck('attributevalue_id')->toArray();
            if($option_ids)
                $this->whereNotIn('id',$option_ids);
        }
        return $this;

    }
}
