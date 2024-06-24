<?php

namespace Domain\Orders\Actions\Cart;

use Domain\Orders\Exceptions\CartNotFoundException;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCartById extends AbstractAction
{
    public function __construct(
        public int  $cartId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Cart
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'cart-cache.' . $this->cartId,
        ])
            ->remember(
                'load-cart-by-id.' . $this->cartId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Cart
    {
        return Cart::find($this->cartId)
            ?? throw new CartNotFoundException(
                __("No cart matching ID :id.", [
                    'id' => $this->cartId
                ])
            );
    }
}
