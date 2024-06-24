<?php

namespace Domain\Sites\Actions\Currencies;

use App\Api\Admin\Sites\Requests\SiteCurrencyRequest;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCurrency;
use Lorisleiva\Actions\Concerns\AsObject;

class ActivateCurrencyForSite
{
    use AsObject;

    public function handle(
        Site                $site,
        SiteCurrencyRequest $request
    ): SiteCurrency
    {
        if (IsCurrencyActiveOnSite::run($site, $request->currency_id)) {
            throw new \Exception(__('Currency Already Active on Site'));
        }

        return $site->siteCurrencies()->create([
            'currency_id' => $request->currency_id,
        ]);
    }
}
