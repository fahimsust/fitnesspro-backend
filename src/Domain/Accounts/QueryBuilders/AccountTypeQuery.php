<?php
namespace Domain\Accounts\QueryBuilders;

use App\Api\Admin\AccountType\Requests\AccountTypeSearchRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Illuminate\Database\Eloquent\Builder;

class AccountTypeQuery extends Builder
{
    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name'], $keyword);
    }
    public function search(AccountTypeSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('condition_id')) {
            $account_type_ids = OrderingCondition::find($request->condition_id)->accountTypes->pluck('id')->toArray();
            if($account_type_ids)
                $this->whereNotIn('id',$account_type_ids);
        }
        if ($request->filled('discount_condition_id')) {
            $account_type_ids = ConditionAccountType::whereConditionId($request->discount_condition_id)->pluck('accounttype_id')->toArray();
            if($account_type_ids)
                $this->whereNotIn('id',$account_type_ids);
        }
        return $this;

    }
}
