<?php

namespace Domain\Sites\Models\QueryBuilders;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class InventoryRuleQuery extends Builder
{
    public function search(Request $request): static
    {
        if ($request->filled('site_id')) {
            $rule_ids = Site::find($request->site_id)->siteInventoryRules->pluck('rule_id')->toArray();
            if($rule_ids)
                $this->whereNotIn('id',$rule_ids);
        }
        return $this;

    }
}
