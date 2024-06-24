<?php

namespace Domain\Orders\Actions\Cart\Item;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadCartItemById extends AbstractAction
{
    public function __construct(
        public int  $cartItemId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): CartItem
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'cart-item-cache.' . $this->cartItemId,
        ])
            ->remember(
                'load-cart-item-by-id.' . $this->cartItemId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): CartItem
    {
        return CartItem::find($this->cartItemId)
            ?? throw new ModelNotFoundException(
                __("No cart item matching ID :id.", [
                    'id' => $this->cartItemId,
                ])
            );
    }
}
