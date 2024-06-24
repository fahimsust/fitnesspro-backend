<?php

namespace Domain\Orders\Actions\Cart\Item\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Actions\Cart\FindProductInCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class FindAdvantageFreeItemsInCart
{
    use AsObject;

    public Cart $cart;
    public CartDiscount $cartDiscount;
    public DiscountAdvantage $advantage;
    private Collection $foundItems;

    public function handle(
        Cart $cart,
        DiscountAdvantage $advantage,
    ): Collection {
        $this->cart = $cart;
        $this->advantage = $advantage;
        $this->foundItems = collect();

        if (! $this->advantage->type()->isAutoAdd()) {
            return $this->foundItems;
        }

        $this->advantage->loadMissingReturn('targetProducts')
            ->each(
                function (Product $product) {
                    if ($item = $this->lookForProductInCart($product)) {
                        $this->foundItems->push($item);
                    }
                }
            );

        return $this->foundItems;
    }

    private function lookForProductInCart(Product $product): CartItem|bool
    {
        return FindProductInCart::run($this->cart, $product)->firstWhere(
            fn (CartItem $item) => FindIfAdvantageAppliedToItem::run($item, $this->advantage)
        )
            ?? false;
    }
}
