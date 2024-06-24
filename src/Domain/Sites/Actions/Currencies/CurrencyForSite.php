<?php

namespace Domain\Sites\Actions\Currencies;

use Domain\Locales\Models\Currency;
use Domain\Sites\Models\SiteCurrency;
use Lorisleiva\Actions\Concerns\AsObject;

class CurrencyForSite
{
    use AsObject;

    public function handle(
        int                $site_id
    ): Currency
    {
        $siteCurrency = SiteCurrency::where('site_id',$site_id)->first();
        if($siteCurrency)
        {
            return $siteCurrency->currency;
        }
        $currency = Currency::where('base',true)->first();

        return $currency;
    }
}
