<?php

namespace Domain\Sites\Actions;

use Domain\Sites\Enums\RequireLogin;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

class SetRequireLoginForSite extends AbstractAction
{
    public function __construct(
        public Site         $site,
        public RequireLogin $requireLogin
    )
    {
    }

    public function execute(): Site
    {
        $this->site->update([
            'require_login' => $this->requireLogin,
        ]);

        return $this->site;
    }
}
