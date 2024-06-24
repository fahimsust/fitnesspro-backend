<?php

namespace Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Discounts\QueryBuilders\AvailableDiscountsQuery;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetAvailableDiscounts
{
    use AsObject;

    public AvailableDiscountsQuery $builder;

    public function __construct()
    {
        $this->builder = (new AvailableDiscountsQuery())
            ->checkDate();
    }

    public function handle(
        ?AvailableDiscountsQuery $builder = null,
        ?Account $account = null,
    ): Collection {
        if ($builder) {
            $this->builder = $builder;
        }

        if ($account) {
            $this->builder->includeAccount($account);
        }

//        dd(
        //Query::toSql($this->builder->handle()),
        // Discount::with('rules.conditions')->first()
        //$this->builder->handle()->get()
        //);
        return $this->builder->handle()->get();
    }
}
