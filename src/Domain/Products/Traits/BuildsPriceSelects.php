<?php

namespace Domain\Products\Traits;

use Domain\Accounts\Models\Account;
use Domain\Products\Actions\Product\Query\BuildPriceSelect;

trait BuildsPriceSelects
{
    public ?Account $customer = null;

    protected function priceSelect(string $alias = "", ...$args): string
    {
        if ($alias != "") {
            $alias = ' as ' . $alias;
        }

        return BuildPriceSelect::now(
                $this->customer,
                ...$args
            ) . $alias;
    }
}
