<?php

namespace Domain\Sites\Actions\Currencies;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCurrency;
use Lorisleiva\Actions\Concerns\AsObject;

class IsCurrencyActiveOnSite
{
    use AsObject;

    public function handle(
        Site $site,
        int $currencyId,
    ): ?SiteCurrency {
        return $site->siteCurrencies()->whereCurrencyId($currencyId)->first();
    }
}
