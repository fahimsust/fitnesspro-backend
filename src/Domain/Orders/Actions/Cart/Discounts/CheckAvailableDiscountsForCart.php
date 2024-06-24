<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Actions\GetAvailableDiscounts;
use Domain\Discounts\Enums\DiscountRelations;
use Domain\Discounts\QueryBuilders\AvailableDiscountsQuery;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\ValueObjects\ToBeAppliedDiscountData;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckAvailableDiscountsForCart
{
    use AsObject;

    public function handle(
        Cart $cart,
        ?Account $account = null,
    ) {
        CheckDiscountsForCart::run(
            GetAvailableDiscounts::run(
                (new AvailableDiscountsQuery())
                    ->includeAccount($account)
                    ->excludeDiscountIds($cart->cartDiscounts->pluck('discount_id'))
                    ->handle()
                    ->with(DiscountRelations::CONDITIONS)
            )->get(),
            $cart
        )->each(
            function (ToBeAppliedDiscountData $toApplyDiscount) use ($cart) {
                ApplyDiscountToCart::run(
                    $cart,
                    $toApplyDiscount->discount
                );
            }
        );
    }
}
