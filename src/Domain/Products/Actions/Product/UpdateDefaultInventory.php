<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\DefaultInventoryRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateDefaultInventory
{
    use AsObject;

    public function handle(
        Product $product,
        DefaultInventoryRequest $request
    ): Product {
        $product->update(
            [
                'default_outofstockstatus_id' => $request->default_outofstockstatus_id,
                'default_distributor_id' => $request->default_distributor_id,
                'default_cost' => $request->default_cost,
                'fulfillment_rule_id' => $request->fulfillment_rule_id,
                'inventoried' => $request->inventoried,
            ]
        );
        return Product::with('details')->withCount('options')->findOrFail($product->id);
    }
}
