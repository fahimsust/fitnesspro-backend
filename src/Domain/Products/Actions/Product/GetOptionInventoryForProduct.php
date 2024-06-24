<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;

class GetOptionInventoryForProduct
{
    public int $actualProductId;

    public function handle(
        array $optionIds,
        int $productId,
        int $siteId,
        int $distributorId
    ) {
        $query = Product::select('id')
            ->joinRelationship(
                'pricing',
                fn ($join) => $join->as('pricing')
            )
            ->leftJoinRelationship('image')
            ->where('parent_product', $productId)
            ->where('pricing.site_id', $siteId)
            ->where('pricing.status', true)
            ->groupBy('id');

        $x = 0;
        collect($optionIds)
            ->each(
                fn (int $optionId) => $query->joinRelationship(
                    'variantOptions',
                    fn ($join) => $join->as('variantOptions' . $x)
                        ->on('variantOptions' . $x . '.option_id', $optionId)
                ) && $x++
            );

        $optionProduct = $query->first();

        if (! $optionProduct) {
            return false;
        }

        $this->actualProductId = $optionProduct->id;

        if ($distributorId > 0) {
            $child = Product::LoadWithDistributor(
                $optionProduct->id,
                $this->distributor_id,
                false,
                $this->customer
            );
        } else {
            $child = new Product(
                $optionProduct->id,
                '',
                true,
                $this->customer
            );
        }
    }
    /*
     *
            function getOptionInventory($option_ids){
            }
     */
}
