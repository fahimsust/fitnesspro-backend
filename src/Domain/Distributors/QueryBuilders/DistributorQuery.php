<?php

namespace Domain\Distributors\QueryBuilders;

use Domain\Discounts\Models\Rule\Condition\ConditionDistributor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DistributorQuery extends Builder
{
    public function search(Request $request): static
    {
        if ($request->filled('condition_id')) {
            $distributor_ids = ConditionDistributor::whereConditionId($request->condition_id)->pluck('distributor_id')->toArray();
            if($distributor_ids)
                $this->whereNotIn('id',$distributor_ids);
        }
        return $this;

    }
}
