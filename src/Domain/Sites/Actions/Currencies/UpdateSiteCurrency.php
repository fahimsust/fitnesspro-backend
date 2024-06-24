<?php

namespace Domain\Sites\Actions\Currencies;

use App\Api\Admin\Sites\Requests\SiteCurrencyRankRequest;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateSiteCurrency
{
    use AsObject;

    public function handle(
        Site                    $site,
        int                     $currencyId,
        SiteCurrencyRankRequest $request
    )
    {
        if (!IsCurrencyActiveOnSite::run($site, $currencyId)) {
            throw new \Exception(__('Currency not active for this site'));
        }

        $site->siteCurrencies()->whereCurrencyId($currencyId)->update([
            'rank' => $request->rank
        ]);
    }
}
