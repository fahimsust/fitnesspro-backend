<?php

namespace Domain\Orders\Actions\Cart\Item\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Actions\Cart\Item\Qty\AdjustCartItemQty;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyAutoAddItemAdvantageToCart
{
    use AsObject;

    public Cart $cart;
    public DiscountAdvantage $advantage;
    private CartItem $cartItem;
    private CartDiscount $cartDiscount;

    public function handle(
        Cart $cart,
        DiscountAdvantage $advantage,
        CartDiscount $cartDiscount,
    ): CartItem {
        $this->cart = $cart;
        $this->advantage = $advantage;
        $this->cartDiscount = $cartDiscount;

        $existingAdvantageFreeItems = FindAdvantageFreeItemsInCart::run(
            $this->cart,
            $this->advantage
        );

        $this->advantage->loadMissingReturn('targetProducts')
            ->each(
                fn (Product $product) => $this->autoAddProduct(
                    $product,
                    $existingAdvantageFreeItems
                )
            );

        return $this->cartItem;
    }

    private function autoAddProduct(Product $product, Collection $existingAdvantageFreeItems)
    {
        $existingItem = $existingAdvantageFreeItems->firstWhere(
            fn (CartItem $item) => $item->isProduct($product)
        );

        if ($existingItem) {
            $this->increaseQtyOfExistingItem(
                $existingItem,
                $this->useQty($product->applyto_qty)
            );
        } else {
            $this->addFreeItemToCart(
                $product,
                $this->useQty($product->applyto_qty)
            );
        }
    }

    private function useQty(int $individualQty)
    {
        return $this->advantage->applyQtyType()->isCombined()
            ? $this->advantage->applyto_qty_combined
            : $individualQty;
    }

    private function increaseQtyOfExistingItem(
        CartItem $item,
        int $applyQty
    ) {
        if ($applyQty <= 0) {
            return;
        }

        //free product has already been added, update qty,
        AdjustCartItemQty::run($item, $applyQty);

        AdjustItemDiscountAdvantageQty::run(
            FindIfAdvantageAppliedToItem::run($item, $this->advantage),
            $applyQty
        );

        $this->cartItem = $item;
    }

    private function addFreeItemToCart(
        Product $product,
        int $applyQty
    ) {
        //free item does not exist in cart yet
        $this->cartItem = $this->cart
            ->itemsCached()
            ->create(
                LoadProductWithEntitiesForCartItem::run(
                    $product->id,
                    $this->cart->site,
                )
                    ->toCartItemDto(
                        $applyQty
                    )
                    ->toModelArray()
            );

        $this->cartItem->setRelation(
            'discountAdvantages',
            collect(
                ApplyAdvantageToCartItem::run(
                    $this->cartDiscount,
                    $this->advantage,
                    $this->cartItem,
                    $applyQty
                )
            )
        );
    }
}
