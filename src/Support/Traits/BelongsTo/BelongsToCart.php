<?php

namespace Support\Traits\BelongsTo;

use Domain\Orders\Actions\Cart\LoadCartById;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCart
{
    private Cart $cartCached;

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function cartCached(): ?Cart
    {
        if(!$this->cart_id) {
            return null;
        }

        if($this->relationLoaded('cart')) {
            return $this->cart;
        }

        return $this->cartCached ??= LoadCartById::now($this->cart_id);
    }
}
