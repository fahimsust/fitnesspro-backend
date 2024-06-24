<?php

namespace Domain\Accounts\QueryBuilders;

use App\Api\Admin\Accounts\Requests\AccountSearchRequest;
use Illuminate\Database\Eloquent\Builder;

class AccountQuery extends Builder
{
    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'first_name', 'last_name', 'email', 'username'], $keyword);
    }
    public function search(AccountSearchRequest $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            )->whenFilled(
                'first_name',
                fn () => $this->where('first_name', $request->first_name) && false
            )->whenFilled(
                'last_name',
                fn () => $this->where('last_name', $request->last_name) && false
            )->whenFilled(
                'type_id',
                fn () => $this->where('type_id', $request->type_id) && false
            )->whenFilled(
                'status_id',
                fn () => $this->where('status_id', $request->status_id) && false
            );
        if ($request->anyFilled(['city', 'country_id', 'state_id'])) {
            $this->whereHas(
                'defaultBillingAddress',
                fn (Builder $query) => $request
                    ->whenFilled(
                        'city',
                        fn () => $query->whereCity($request->city) && false
                    )
                    ->whenFilled(
                        'country_id',
                        fn () => $query->whereCountryId($request->country_id) && false
                    )
                    ->whenFilled(
                        'state_id',
                        fn () => $query->whereStateId($request->state_id) && false
                    )
            );
        }
        return $this;
    }
}
