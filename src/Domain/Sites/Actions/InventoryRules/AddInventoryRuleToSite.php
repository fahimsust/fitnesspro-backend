<?php

namespace Domain\Sites\Actions\InventoryRules;

use App\Api\Admin\Sites\Requests\SiteInventoryRuleRequest;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class AddInventoryRuleToSite
{
    use AsObject;

    public function handle(
        Site $site,
        SiteInventoryRuleRequest $request
    ): Collection {
        if (IsInventoryRuleAssignedToSite::run($site, $request->rule_id)) {
            throw new \Exception(__('Inventory rule already exists in site'));
        }

        $site->siteInventoryRules()->create(
            [
                'rule_id' => $request->rule_id,
            ]
        );

        return $site->siteInventoryRules;
    }
}
