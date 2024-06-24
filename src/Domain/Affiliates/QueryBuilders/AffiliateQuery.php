<?php

namespace Domain\Affiliates\QueryBuilders;

use App\Api\Admin\Affiliates\Requests\AffiliateSearchRequest;
use Domain\Affiliates\Models\Referral;
use Illuminate\Database\Eloquent\Builder;

class AffiliateQuery extends Builder
{
    //    use CanSearchByKeyword;

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name', 'email', 'account_id'], $keyword);
    }

    public function search(AffiliateSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            )
            ->whenFilled(
                'status',
                fn () => $this->whereStatus($request->status) && false,
                fn () => $this->whereStatus(true) && false
            );
        if ($request->filled('order_id')) {
            $affiliate_ids = Referral::whereOrderId($request->order_id)->pluck('affiliate_id')->toArray();
            if ($affiliate_ids)
                $this->whereNotIn('id', $affiliate_ids);
        }
        return $this;
    }
}
