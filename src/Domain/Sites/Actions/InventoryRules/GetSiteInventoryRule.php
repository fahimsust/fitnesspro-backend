<?php

namespace Domain\Sites\Actions\InventoryRules;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteInventoryRule;
use Lorisleiva\Actions\Concerns\AsObject;

class GetSiteInventoryRule
{
    use AsObject;

    public function handle(
        Site $site,
        int $rule_id
    ): ?SiteInventoryRule {
        return $site->siteInventoryRules()->whereRuleId($rule_id)->first();
    }
}
