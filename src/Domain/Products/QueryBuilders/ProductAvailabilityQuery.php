<?php

namespace Domain\Products\QueryBuilders;

use App\Api\Admin\Discounts\Requests\ConditionAvailabilityRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionOutOfStockStatus;
use Domain\Discounts\Models\Rule\Condition\ConditionProductAvailability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductAvailabilityQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name','display'], $keyword);
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('condition_id')) {
            $availability_ids = ConditionOutOfStockStatus::whereConditionId($request->condition_id)->pluck('outofstockstatus_id')->toArray();
            if($availability_ids)
                $this->whereNotIn('id',$availability_ids);
        }
        if ($request->filled('availability_condition_id')) {
            $availability_ids = ConditionProductAvailability::whereConditionId($request->availability_condition_id)->pluck('availability_id')->toArray();
            if($availability_ids)
                $this->whereNotIn('id',$availability_ids);
        }
        return $this;

    }
}
