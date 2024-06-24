<?php

namespace Domain\Products\Actions;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Exceptions\DistributorNotFoundException;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadProductAvailabilityById extends AbstractAction
{
    public function __construct(
        public int  $availabilityId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): ProductAvailability
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'availability-id-cache.' . $this->availabilityId,
        ])
            ->remember(
                'load-availability-by-id.' . $this->availabilityId,
                60 * 10,
                fn() => $this->load()
            );
    }

    public function load(): ProductAvailability|Model
    {
        return ProductAvailability::find($this->availabilityId)
            ?? throw new ModelNotFoundException(
                __("No availability matching ID {$this->availabilityId}.")
            );
    }
}
