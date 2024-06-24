<?php

namespace Domain\Orders\Actions\Cart\LinkedAccessories;

use Domain\Orders\Actions\Cart\Item\Qty\UpdateCartItemQty;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class UpdateLinkedAccessoriesQty implements CanReceiveExceptionCollection
{
    use AsObject,
        HasExceptionCollection;

    public function handle(CartItem $item): static
    {
        $item->accessoryLinkedActionItems
            ->each(
                fn (CartItem $cartItem) => (new UpdateCartItemQty())
                    ->ignoreQtyLimits()
                    ->handle($cartItem, $item->qty)
                    ->transferExceptionsTo($this)
            );

        return $this;
    }
}
