<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Option\ProductOption;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteProductOption
{
    use AsObject;

    public function handle(
        ProductOption $productOption,
    ) {
        if ($productOption->variants()->exists()) {
            throw new \Exception(__("Can't delete: there are products using this product option. Update these products before deleting: :products", [
                'products' => $productOption->variants()
                    ->select("title")
                    ->pluck('title')
                    ->implode(", ")
            ]));
        }
        $productOption->optionValues()->delete();
        $productOption->delete();
    }
}
