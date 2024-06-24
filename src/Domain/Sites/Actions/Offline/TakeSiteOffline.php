<?php

namespace Domain\Sites\Actions\Offline;

use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Actions\GetLargeRandomInt;

class TakeSiteOffline
{
    use AsObject;

    public function handle(
        Site $site
    ): Site {
        $site->update(
            [
                'status' => false,
                'offline_key' => GetLargeRandomInt::run(),
            ]
        );

        return $site;
    }
}
