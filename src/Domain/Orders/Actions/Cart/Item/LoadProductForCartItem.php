<?php

namespace Domain\Orders\Actions\Cart\Item;

use Domain\Products\Exceptions\ProductNotFoundException;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadProductForCartItem extends AbstractAction
{
    public function __construct(
        public int  $productId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Product
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'product-cache.' . $this->productId,
        ])
            ->remember(
                'load-product-for-cart-item.' . $this->productId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Product
    {
        return Product::query()
            ->whereId($this->productId)
            ->with(
                Product::$loadForCartRelations
                + ['parent' => Product::$loadForCartRelations]
            )
            ->first()
            ?? throw new ProductNotFoundException(__("No product matching ID {$this->productId} for cart item."));
    }
}
