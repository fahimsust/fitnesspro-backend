<?php

namespace Domain\Sites\Actions;

use Domain\Sites\Exceptions\SiteNotFoundException;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadSiteByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $siteId,
    )
    {
    }

    public function execute(): Site
    {
        return Cache::remember(
            'load-site-by-id.' . $this->siteId,
            60 * 5,
            fn() => Site::find($this->siteId)
                ?? throw new SiteNotFoundException(__("No site matching ID {$this->siteId}."))
        );
    }
}
