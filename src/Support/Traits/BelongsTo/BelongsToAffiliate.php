<?php

namespace Support\Traits\BelongsTo;

use Domain\Affiliates\Actions\LoadAffiliateByIdFromCache;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToAffiliate
{
    private Affiliate $affiliateCached;

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function affiliateCached(): ?Affiliate
    {
        if (!$this->affiliate_id) {
            return null;
        }

        if ($this->relationLoaded('affiliate')) {
            return $this->affiliate;
        }

        return $this->affiliateCached
            ??= LoadAffiliateByIdFromCache::now($this->affiliate_id);
    }
}
