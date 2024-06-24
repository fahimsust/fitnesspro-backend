<?php

namespace Domain\Locales\Actions;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadStateByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $stateId,
    )
    {

    }

    public function execute(): StateProvince
    {
        return Cache::tags([
            "state-cache.{$this->stateId}"
        ])
            ->remember(
                'load-state-by-id.' . $this->stateId,
                60 * 60 * 24,
                fn() => StateProvince::find($this->stateId)
                    ?? throw new ModelNotFoundException(
                        __("No state matching ID :id.", [
                            'id' => $this->stateId
                        ])
                    )
            );
    }
}
