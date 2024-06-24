<?php

namespace Domain\Sites\Actions\InventoryRules;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveInventoryRuleFromSite
{
    use AsObject;

    public function handle(
        Site $site,
        int $rule_id
    ): Collection {
        if (! IsInventoryRuleAssignedToSite::run($site, $rule_id)) {
            throw new \Exception(__('Inventory rule not assigned to site'));
        }

        $site->siteInventoryRules()->whereRuleId($rule_id)->delete();

        return $site->siteInventoryRules()->get();
    }
}
