<?php

namespace Domain\Locales\Models\QueryBuilders;

use Domain\Discounts\Models\Rule\Condition\ConditionCountry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CountryQuery extends Builder
{
    public function search(Request $request): static
    {
        if ($request->filled('condition_id')) {
            $country_ids = ConditionCountry::whereConditionId($request->condition_id)->pluck('country_id')->toArray();
            if($country_ids)
                $this->whereNotIn('id',$country_ids);
        }
        return $this;

    }
}
