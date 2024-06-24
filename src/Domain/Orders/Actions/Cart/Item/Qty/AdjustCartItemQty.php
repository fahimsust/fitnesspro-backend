<?php

namespace Domain\Orders\Actions\Cart\Item\Qty;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class AdjustCartItemQty implements CanReceiveExceptionCollection
{
    use AsObject,
        HasExceptionCollection;

    public CartItem $item;

    public function handle(
        CartItem $item,
        int $qty,
    ): static {
        $updateToQty = $item->qty + $qty;

        UpdateCartItemQty::run($item, $updateToQty)
            ->transferExceptionsTo($this);

        return $this;
    }
}
