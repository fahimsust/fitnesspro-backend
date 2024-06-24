<?php

namespace Domain\Sites\Actions\Currencies;

use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class DeactivateCurrencyForSite
{
    use AsObject;

    public function handle(
        Site $site,
        int  $currencyId
    ): void
    {
        if (!IsCurrencyActiveOnSite::run($site, $currencyId)) {
            throw new \Exception(__('Currency is not active yet'));
        }

        $site->siteCurrencies()->whereCurrencyId($currencyId)->delete();
    }
}
