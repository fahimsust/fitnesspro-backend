<?php

namespace App\Api\Orders\Controllers\Cart;

use App\Api\Orders\Requests\Cart\AddItemToCartRequest;
use App\Api\Orders\Requests\Cart\RemoveItemFromCartRequest;
use App\Api\Orders\Requests\Cart\UpdateCartItemQtyRequest;
use App\Api\Orders\Resources\Cart\CartItemResource;
use App\Api\Orders\Resources\Cart\CartResource;
use Domain\Orders\Actions\Cart\Discounts\AnalyzeDiscountsForCart;
use Domain\Orders\Actions\Cart\Item\AddItemToCartFromDto;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Actions\Cart\Item\Qty\UpdateCartItemQty;
use Domain\Orders\Actions\Cart\Item\RemoveItemFromCart;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Enums\Cart\CartItemRelations;
use Domain\Orders\Enums\Cart\CartRelations;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CartItemController extends AbstractController
{
    public function store(AddItemToCartRequest $request)
    {
        $added = AddItemToCartFromDto::run(
            cart(true),
            LoadProductWithEntitiesForCartItem::run(
                $request->product_id,
                site()
            )
                ->toCartItemDto(
                    $request->qty,
                    $request->option_custom_values,
                    $request->custom_field_values,
                    $request->accessories,
                )
        );

        SaveCartToSession::run($added->cart);

        AnalyzeDiscountsForCart::run(
            $added->cart->fresh(CartRelations::ITEMS),
            $request->user()
        );

        return response(
            $added->resultAsResource(),
            Response::HTTP_CREATED
        );
    }

    public function show(int $cartItemId)
    {
        return [
            'item' => new CartItemResource(
                CartItem::whereId($cartItemId)
                    ->whereBelongsTo(cart())
                    ->with(CartItemRelations::standard())
                    ->first()
                ?? throw new ModelNotFoundException(__('Item not found in cart'))
            ),
        ];
    }

    public function update(UpdateCartItemQtyRequest $request)
    {
        UpdateCartItemQty::run(
            $request->cartItem,
            $request->qty
        );

        AnalyzeDiscountsForCart::run(
            $request->cart->fresh(CartRelations::ITEMS),
            $request->user()
        );

        return [
            'cart' => new CartResource($request->cart),
        ];
    }

    public function destroy(RemoveItemFromCartRequest $request)
    {
        RemoveItemFromCart::run(
            $request->cartItem
            ?? throw new ModelNotFoundException(__('Cart item not found'))
        );

        AnalyzeDiscountsForCart::run(
            $request->cart->fresh(CartRelations::ITEMS),
            $request->user()
        );

        return response(
            ['cart' => new CartResource($request->cart)],
            Response::HTTP_OK
        );
    }
}
