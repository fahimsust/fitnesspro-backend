<?php

namespace Domain\Discounts\QueryBuilders;

use App\Api\Admin\Discounts\Requests\DiscountSearchRequest;
use Illuminate\Database\Eloquent\Builder;

class DiscountQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name', 'display'], $keyword);
    }

    public function search(DiscountSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            )
            ->whenFilled(
                'status',
                fn () => $this->whereStatus($request->status) && false
            );
        return $this;
    }
}
