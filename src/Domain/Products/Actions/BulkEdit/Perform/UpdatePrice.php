<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetPriceError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class UpdatePrice
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetPriceError::run($request);
        foreach ($request->ids as $product_id) {
            ProductPricing::updateOrCreate(
                [
                    'product_id' => $product_id,
                    'site_id' => $request->site_id
                ],
                [
                    'price_reg' => $request->price_reg,
                    'onsale' => $request->onsale ? $request->onsale : false,
                    'price_sale' => $request->price_sale ? $request->price_sale : null,
                ]
            );
        }
        return CreateActivity::run(
            $request->ids,
            [
                'site_id' => $request->site_id,
                'price_reg' => $request->price_reg,
                'onsale' => $request->onsale ? $request->onsale : false,
                'price_sale' => $request->price_sale ? $request->price_sale : "",
            ],
            ActionList::SET_PRICING,
        );
    }
}
