<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Exceptions\ProductNotFoundException;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadProductByIdFromCache extends AbstractAction
{
    public function __construct(
        public int $productId,
    )
    {
    }

    public function execute(): Product
    {
        return Cache::tags([
            "product-cache.{$this->productId}"
        ])
            ->remember(
                'load-product-by-id.' . $this->productId,
                60 * 5,
                fn() => Product::find($this->productId)
                    ?? throw new ProductNotFoundException(__("No product matching ID {$this->productId}."))
            );
    }
}
