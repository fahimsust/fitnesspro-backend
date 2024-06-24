<?php

namespace Domain\Accounts\QueryBuilders;

use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MemberShipLevelQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name'], $keyword);
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('condition_id')) {
            $level_ids = ConditionMembershipLevel::whereConditionId($request->condition_id)->pluck('membershiplevel_id')->toArray();
            if($level_ids)
                $this->whereNotIn('id',$level_ids);
        }
        return $this;

    }
}
