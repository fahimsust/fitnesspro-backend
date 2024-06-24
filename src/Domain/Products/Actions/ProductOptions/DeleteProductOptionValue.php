<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteProductOptionValue
{
    use AsObject;

    public function handle(
        ProductOptionValue $productOptionValue,
    )
    {
        if ($productOptionValue->variants()->exists()) {
            throw new \Exception(
                __("Can't delete: there are products using this option value. ".
                    "Update these products before deleting: :products", [
                    'products' => $productOptionValue->variants()
                        ->select("title")
                        ->pluck('title')
                        ->implode(", ")
                ])
            );
        }

        $productOptionValue->delete();
    }
}
