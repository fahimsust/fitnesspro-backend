<?php

namespace Support\Actions;

use Domain\Accounts\Models\Account;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Helpers\HandleMessageKeys;

class HandleSiteAccountMessageKeys
{
    use AsObject;

    public function handle(
        Site $site,
        Account $account,
        array $extraKeys = []
    ): HandleMessageKeys {
        return (new HandleMessageKeys($extraKeys))
            ->setSite($site)
            ->setAccount($account);
    }
}
