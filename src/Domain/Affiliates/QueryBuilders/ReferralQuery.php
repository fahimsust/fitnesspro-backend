<?php

namespace Domain\Affiliates\QueryBuilders;

use App\Api\Admin\Referrals\Requests\ReferralSearchRequest;
use Domain\Affiliates\Models\Referral;
use Illuminate\Database\Eloquent\Builder;

class ReferralQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
    {
        return $this->whereHas(
            'order',
            fn (Builder $q) => $q->like('order_no', $keyword)
        );
    }

    public function searchAffiliateName(string $name)
    {
        return $this->whereHas(
            'affiliate',
            fn (Builder $q) => $q->like('name', $name)
        );
    }

    public function search(ReferralSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            )
            ->whenFilled(
                'name',
                fn () => $this->searchAffiliateName($request->name) && false
            )
            ->whenFilled(
                'status_id',
                fn () => $this->whereStatusId($request->status_id) && false
            );
            if ($request->filled('order_id')) {
                $referral_ids = Referral::whereOrderId($request->order_id)->pluck('id')->toArray();
                if($referral_ids)
                    $this->whereNotIn('id',$referral_ids);
            }
        return $this;
    }
}
