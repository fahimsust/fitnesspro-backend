<?php

namespace Support\Traits\BelongsTo;

use Domain\Sites\Actions\LoadSiteByIdFromCache;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSite
{
    private Site $siteCached;

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function siteCached(): ?Site
    {
        if (!$this->site_id) {
            return null;
        }

        if ($this->relationLoaded('site')) {
            return $this->site;
        }

        return $this->siteCached ??= LoadSiteByIdFromCache::now($this->site_id);
    }
}
