<?php

namespace Domain\Distributors\Actions;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Exceptions\DistributorNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadDistributorByIdFromCache extends AbstractAction
{
    public function __construct(
        public int  $distributorId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Distributor
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'distributor-id-cache.' . $this->distributorId,
        ])
            ->remember(
                'load-distributor-by-id.' . $this->distributorId,
                60 * 10,
                fn() => $this->load()
            );
    }

    public function load(): Distributor|Model
    {
        return Distributor::find($this->distributorId)
            ?? throw new DistributorNotFoundException(
                __("No distributor matching distributor ID {$this->distributorId}.")
            );
    }
}
