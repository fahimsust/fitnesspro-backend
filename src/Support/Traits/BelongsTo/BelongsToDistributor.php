<?php

namespace Support\Traits\BelongsTo;

use Domain\Distributors\Actions\LoadDistributorByIdFromCache;
use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToDistributor
{
    private Distributor $distributorCached;

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }

    public function distributorCached(): ?Distributor
    {
        if (!$this->distributor_id) {
            return null;
        }

        if ($this->relationLoaded('distributor')) {
            return $this->distributor;
        }

        return $this->distributorCached ??= LoadDistributorByIdFromCache::now(
            $this->distributor_id
        );
    }
}
