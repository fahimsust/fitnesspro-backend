<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetOrderingRuleSiteError;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetSiteError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class SetOrderingRule
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetOrderingRuleSiteError::run($request);
        ProductPricing::where('site_id', $request->site_id)
            ->whereIn('product_id', $request->ids)
            ->update(['ordering_rule_id' => $request->ordering_rule_id]);

        return CreateActivity::run(
            $request->ids,
            [
                'ordering_rule_id' => $request->ordering_rule_id,
                'site_id' => $request->site_id,
            ],
            ActionList::SET_ORDERING_RULE,
        );
    }
}
