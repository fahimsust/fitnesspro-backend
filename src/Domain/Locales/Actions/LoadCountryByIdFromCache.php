<?php

namespace Domain\Locales\Actions;

use Domain\Locales\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCountryByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $countryId,
    )
    {

    }

    public function execute(): Country
    {
        return Cache::tags([
            "country-cache.{$this->countryId}"
        ])
            ->remember(
                'load-country-by-id.' . $this->countryId,
                60 * 60 * 24,
                fn() => Country::find($this->countryId)
                    ?? throw new ModelNotFoundException(
                        __("No country matching ID :id.", [
                            'id' => $this->countryId
                        ])
                    )
            );
    }
}
