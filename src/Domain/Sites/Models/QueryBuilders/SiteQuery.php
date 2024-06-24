<?php

namespace Domain\Sites\Models\QueryBuilders;

use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SiteQuery extends Builder
{
    public function search(Request $request): static
    {
        if ($request->filled('condition_id')) {
            $site_ids = ConditionSite::whereConditionId($request->condition_id)->pluck('site_id')->toArray();
            if($site_ids)
                $this->whereNotIn('id',$site_ids);
        }
        return $this;

    }
}
