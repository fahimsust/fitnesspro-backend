<?php

namespace Domain\Orders\Actions\Cart\Item;

use Domain\Orders\Models\Carts\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCartItemsWithProduct extends AbstractAction
{
    public function __construct(
        public Cart $cart,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Collection
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'cart-cache.' . $this->cart->id,
        ])
            ->remember(
                'load-cart-items-with-product.' . $this->cart->id,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Collection
    {
        return $this->cart->items()
            ->with('product')
            ->get();
    }
}
