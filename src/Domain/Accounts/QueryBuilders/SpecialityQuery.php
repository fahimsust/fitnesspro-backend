<?php
namespace Domain\Accounts\QueryBuilders;

use App\Api\Admin\Speciality\Requests\SpecialitySearchRequest;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Illuminate\Database\Eloquent\Builder;

class SpecialityQuery extends Builder
{
    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name'], $keyword);
    }
    public function search(SpecialitySearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('condition_id')) {
            $speciality_ids = OrderingCondition::find($request->condition_id)->specialties->pluck('id')->toArray();
            if($speciality_ids)
                $this->whereNotIn('id',$speciality_ids);
        }
        return $this;

    }
}
