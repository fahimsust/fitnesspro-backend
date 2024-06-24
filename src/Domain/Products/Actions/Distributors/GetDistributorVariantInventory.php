<?php

namespace Domain\Products\Actions\Distributors;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class GetDistributorVariantInventory
{
    use AsObject;

    public function handle(
        Product $product,
    ): array
    {
        $productDistributors = $product->productDistributors;
        $distributors = Distributor::all();
        $productDistributorsForAllDistributors = [];

        foreach ($distributors as $value) {
            $distributor = $productDistributors->first(function ($item) use ($value) {
                return $item->distributor_id == $value->id;
            });

            $productDistributorsForAllDistributors[] = [
                'id' => $value->id,
                'name' => $value->name,
                'cost' => $distributor ? $distributor->cost : "",
                'outofstockstatus_id' => $distributor ? $distributor->outofstockstatus_id : null,
                'stock_qty' => $distributor ? $distributor->stock_qty : "",
            ];
        };

        return $productDistributorsForAllDistributors;
    }
}
