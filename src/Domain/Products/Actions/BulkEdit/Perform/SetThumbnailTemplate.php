<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetThumbnailTemplateError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Lorisleiva\Actions\Concerns\AsObject;

class SetThumbnailTemplate
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetThumbnailTemplateError::run($request);
        ProductSettings::whereIn('product_id',$request->ids)->update(['product_thumbnail_template'=>$request->template_id]);
        return CreateActivity::run(
            $request->ids,
            [
                'product_thumbnail_template' => $request->template_id,
            ],
            ActionList::ASSIGN_DEFAULT_CATEGORY,
        );
    }
}
