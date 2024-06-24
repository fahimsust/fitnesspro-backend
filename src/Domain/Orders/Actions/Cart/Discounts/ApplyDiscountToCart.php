<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Discounts\Actions\AbstractApplyDiscountCodeAction;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyDiscountToCart extends AbstractApplyDiscountCodeAction
{
    use AsObject;

    public Cart $cart;
    public Discount $discount;
    public CartDiscount $cartDiscount;
    public ?Collection $appliedAdvantages = null;

    public function handle(
        Cart          $cart,
        Discount      $discount,
        ?CartDiscount $cartDiscount = null
    ): static
    {
        $this->cart = $cart;
        $this->discount = $discount;

        $this->appliedAdvantages = ApplyAdvantagesToCart::run(
            $this->cart,
            $this->cartDiscount = $cartDiscount
                ?? $this->findCreateCartDiscount(),
            $discount->advantages,
        );

        $this->cart->cartDiscounts->push($this->cartDiscount);

        return $this;
    }

    private function findCreateCartDiscount(): CartDiscount|Model
    {
        return $this->cart->cartDiscounts->firstWhere(
            fn(CartDiscount $cartDiscount) => $cartDiscount->discount_id === $this->discount->id
        )
            ?? $this->cart->cartDiscounts()->create([
                'discount_id' => $this->discount->id,
                'applied' => 1,
            ]);
    }
}
