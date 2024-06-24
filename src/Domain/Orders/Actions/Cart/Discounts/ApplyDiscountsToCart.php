<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Discounts\Collections\ToBeAppliedDiscountCollection;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\ValueObjects\ToBeAppliedDiscountData;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyDiscountsToCart
{
    use AsObject;
    public Collection $appliedDiscounts;

    private Cart $cart;

    public function handle(
        Cart $cart,
        ToBeAppliedDiscountCollection $discounts
    ) {
        $this->cart = $cart;

        $discounts
            ->each(
                fn (ToBeAppliedDiscountData $toApplyDiscount) => $this->applyDiscount($toApplyDiscount)
            );
    }

    private function applyDiscount(ToBeAppliedDiscountData $toApplyDiscount)
    {
        for ($x = 0; $x < $toApplyDiscount->countToApply; $x++) {
            $this->appliedDiscounts->push(
                ApplyDiscountToCart::run(
                    $this->cart,
                    $toApplyDiscount->discount
                )
            );
        }
    }
}
