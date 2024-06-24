<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteInventoryRuleRequest;
use Domain\Sites\Actions\InventoryRules\AddInventoryRuleToSite;
use Domain\Sites\Actions\InventoryRules\RemoveInventoryRuleFromSite;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteInventoryRuleController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->inventoryRules,
            Response::HTTP_OK
        );
    }

    public function store(Site $site, SiteInventoryRuleRequest $request)
    {
        return response(
            AddInventoryRuleToSite::run($site, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Site $site, int $ruleId)
    {
        return response(
            RemoveInventoryRuleFromSite::run($site, $ruleId),
            Response::HTTP_OK
        );
    }
}
