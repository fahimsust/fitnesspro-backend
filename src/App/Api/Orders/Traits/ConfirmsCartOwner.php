<?php

namespace App\Api\Orders\Traits;

use Domain\Orders\Actions\Cart\ConfirmCartOwnerMatchesUser;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

trait ConfirmsCartOwner
{
    public Cart $cart;
    public CartItem $cartItem;

    protected function confirmCartOwner(Request $request)
    {
        ConfirmCartOwnerMatchesUser::fromRequest(
            $this->cart = cart(), //confirm cart exists
            $request
        )->throwOnFailure();

        return true;
    }

    protected function itemIsInCart(int $cartItemId)
    {
        $this->cartItem = CartItem::whereBelongsTo($this->cart)
            ->with($this->itemRelations())
            ->find($cartItemId, $this->itemSelect())
            ?? throw new ModelNotFoundException(__('Item not found in cart'));

        return true;
    }

    protected function itemRelations(): array
    {
        return [];
    }

    protected function itemSelect(): ?array
    {
        return ['id'];
    }
}
