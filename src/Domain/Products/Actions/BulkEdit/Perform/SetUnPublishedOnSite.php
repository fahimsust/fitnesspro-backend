<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetSiteError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class SetUnPublishedOnSite
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetSiteError::run($request);
        ProductPricing::where('site_id', $request->site_id)
            ->whereIn('product_id', $request->ids)
            ->update(['status' => 0]);

        return CreateActivity::run(
            $request->ids,
            [
                'status' => $request->status,
            ],
            ActionList::PUBLISH_ON_SITE,
        );
    }
}
