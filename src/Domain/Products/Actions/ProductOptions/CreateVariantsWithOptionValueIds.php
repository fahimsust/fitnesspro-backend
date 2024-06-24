<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateVariantsWithOptionValueIds
{
    use AsObject;

    private Product $parentProduct;

    public function handle(
        Product    $parentProduct,
        Collection $collectionOfComboOptionValueIds,
        int       $stockQty = 1,
    ): ?Collection
    {
        $variants = new Collection();

        $productOptionValues = GetProductOptionValuesForCombinationIds::run(
            $collectionOfComboOptionValueIds->toArray(),
        );

        $collectionOfComboOptionValueIds->each(
            fn(array $optionValueIds) => $variants->push(
                CreateVariantUsingOptionValueIds::run(
                    $parentProduct,
                    $optionValueIds,
                    $stockQty,
                    $productOptionValues
                )
            )
        );

        return $variants->filter();
    }
}
