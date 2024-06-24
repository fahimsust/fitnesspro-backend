<?php

namespace Domain\Affiliates\Actions;

use Domain\Affiliates\Exceptions\AffiliateNotFoundException;
use Domain\Affiliates\Models\Affiliate;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadAffiliateByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $affiliateId,
    )
    {
    }

    public function execute(): Affiliate
    {
        return Cache::tags([
            "affiliate-cache.{$this->affiliateId}"
        ])
            ->remember(
                'load-affiliate-by-id.' . $this->affiliateId,
                60 * 5,
                fn() => Affiliate::find($this->affiliateId)
                    ?? throw new AffiliateNotFoundException(__("No affiliate matching ID {$this->affiliateId}."))
            );
    }
}
