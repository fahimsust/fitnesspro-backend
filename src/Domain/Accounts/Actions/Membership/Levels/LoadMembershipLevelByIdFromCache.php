<?php

namespace Domain\Accounts\Actions\Membership\Levels;

use Domain\Accounts\Exceptions\Membership\Level\MembershipLevelNotFoundException;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;
use function __;

class LoadMembershipLevelByIdFromCache extends AbstractAction
{
    public function __construct(
        public int  $levelId,
    )
    {
    }

    public function execute(): MembershipLevel
    {
        return Cache::tags([
            "membership-level-cache.{$this->levelId}"
        ])
            ->remember(
                'load-membership-level-by-id.' . $this->levelId,
                60 * 10,
                fn() => MembershipLevel::find($this->levelId)
                    ?? throw new MembershipLevelNotFoundException(__("No level matching ID {$this->levelId}."))
            );
    }
}
