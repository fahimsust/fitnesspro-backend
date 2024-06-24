<?php

namespace Domain\Orders\Actions\Cart\Item\Options;

use Domain\Orders\Models\Carts\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCartItemOptionsFromCart extends AbstractAction
{
    public function __construct(
        public Cart $cart,
        public bool $useCache = false
    )
    {
    }

    public function execute(): Collection
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            "cart-cache.{$this->cart->id}"
        ])
            ->remember(
                "cart-item-options-{$this->cart->id}",
                now()->addMinutes(5),
                fn() => $this->load()
            );
    }

    protected function load(): Collection
    {
        return $this->cart->options()
            ->with(['item', 'option', 'optionValue'])
            ->get();
    }
}
