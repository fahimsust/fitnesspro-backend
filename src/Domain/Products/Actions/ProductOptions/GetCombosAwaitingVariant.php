<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class GetCombosAwaitingVariant
{
    use AsObject;


    private Product $parentProduct;
    private array $activeCombinationIds;
    private Collection $comboOptionValueIdsKeyed;

    public function handle(
        Product $parentProduct
    ): Collection
    {
        $this->parentProduct = $parentProduct;

        if (!$this->hasWaitingCombos()) {
            return collect();
        }

        $this->comboOptionValueIdsKeyed = collect($this->activeCombinationIds)
            ->mapWithKeys(
                function (array $optionValueIds) {
                    natsort($optionValueIds);

                    return [
                        implode(",", $optionValueIds) => $optionValueIds
                    ];
                }
            );

        Product::select(
            "id",
            DB::raw("GROUP_CONCAT(option_id ORDER BY option_id ASC SEPARATOR ',') as option_ids_string")
        )
            ->where('parent_product', $this->parentProduct->id)
            ->joinRelationship('variantOptions')
            ->groupBy('products.id')
            ->get()
            ->each(
                function (Product $product) {
                    if ($this->comboOptionValueIdsKeyed->has($product->option_ids_string)) {
                        unset($this->comboOptionValueIdsKeyed[$product->option_ids_string]);
                    }
                }
            );

        return $this->comboOptionValueIdsKeyed;
    }

    private function hasWaitingCombos(): bool
    {
        $checker = CheckIfProductHasCombosAwaitingVariants::run($this->parentProduct);
        $this->activeCombinationIds = $checker->activeCombinationIds();

        return $checker->hasSome();
    }
}
