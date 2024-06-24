<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteProduct
{
    use AsObject;

    public function handle(
        Product $product,
    ) {
        $product->settings()->delete();
        $product->details()->delete();
        $product->pricing()->delete();
        $product->delete();
    }
}
