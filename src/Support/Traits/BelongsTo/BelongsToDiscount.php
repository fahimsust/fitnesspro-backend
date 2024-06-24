<?php

namespace Support\Traits\BelongsTo;

use Domain\Discounts\Models\Discount;
use Domain\Distributors\Actions\LoadDistributorByIdFromCache;

trait BelongsToDiscount
{
    private Discount $discountCached;

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function discountCached(): ?Discount
    {
        if (!$this->discount_id) {
            return null;
        }

        if ($this->relationLoaded('discount')) {
            return $this->discount;
        }

        return $this->discountCached ??= LoadDistributorByIdFromCache::now($this->discount_id);
    }
}
