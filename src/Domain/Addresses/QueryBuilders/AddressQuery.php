<?php

namespace Domain\Addresses\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class AddressQuery extends Builder
{

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['company', 'address_1', 'city', 'postal_code', 'phone', 'label'], $keyword);
    }

    public function accountAddressSearch(int $account_id, string $keyword)
    {
        return $this->basicKeywordSearch($keyword)
            ->whereHas(
                'accounts',
                fn (Builder $query) => $query->where('accounts.id', $account_id)
            );
    }

    public function accountWithoutAddressSearch(string $keyword)
    {
        return $this->basicKeywordSearch($keyword)
            ->whereDoesntHave('accounts');
    }
}
