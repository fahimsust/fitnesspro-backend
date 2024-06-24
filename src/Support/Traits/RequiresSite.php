<?php

namespace Support\Traits;

use Domain\Sites\Models\Site;

trait RequiresSite
{
    public Site $site;

    public function site(Site $site): static
    {
        $this->site = $site;

        return $this;
    }
}
