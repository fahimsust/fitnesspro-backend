<?php

namespace Domain\Locales\Models\QueryBuilders;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CurrencyQuery extends Builder
{
    public function search(Request $request): static
    {
        if ($request->filled('site_id')) {
            $currency_ids = Site::find($request->site_id)->siteCurrencies->pluck('currency_id')->toArray();
            if($currency_ids)
                $this->whereNotIn('id',$currency_ids);
        }
        return $this;

    }
}
