<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Enums\DiscountRelations;
use Domain\Discounts\QueryBuilders\AvailableDiscountsQuery;
use Domain\Orders\Enums\Cart\CartRelations;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\ValueObjects\ToBeAppliedDiscountData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class AnalyzeDiscountsForCart
{
    use AsObject;

    private CheckDiscountsForCart $checked;

    public function handle(
        Cart $cart,
        ?Account $account = null,
    ): CheckDiscountsForCart {
        $cart->loadMissing([
            CartRelations::CART_DISCOUNTS,
            CartRelations::DISCOUNT_CODES,
        ]);

        $this->checked = new CheckDiscountsForCart();

        $this->checked->handle(
            $this->getDiscountsToCheck($cart, $account),
            $cart,
            $account
        )->each(
            function (ToBeAppliedDiscountData $toApplyDiscount) use ($cart) {
                ApplyDiscountToCart::run(
                    $cart,
                    $toApplyDiscount->discount
                );
            }
        );

        return $this->checked;
    }

    protected function getDiscountsToCheck(Cart $cart, ?Account $account)
    {
        return $this->discountsAlreadyInCartQuery($cart)
            ->when(
                $account,
                fn (Builder $query) => $query->addSelect(DB::raw('0 as discount_used'))
            )
            ->union(
                $this->discountsNotAlreadyInCartQuery($account, $cart)
            )->get();
    }

    protected function discountsNotAlreadyInCartQuery(?Account $account, Cart $cart)
    {
        return (new AvailableDiscountsQuery())
            ->checkDate()
            ->includeAccount($account)
            //exclude discounts already applied to cart
            ->excludeDiscountIds($cart->cartDiscounts->pluck('discount_id'))
            ->handle()
            ->with(DiscountRelations::CONDITIONS)
            //ignore discounts with require code (only used when applying a code to cart)
            ->whereDoesntHave(
                DiscountRelations::CONDITIONS,
                fn (Builder $query) => $query->where(
                    'condition_type_id',
                    '=',
                    DiscountConditionTypes::REQUIRED_DISCOUNT_CODE
                )
            );
    }

    private function discountsAlreadyInCartQuery(Cart $cart)
    {
        return AvailableDiscountsQuery::startQuery()
            ->whereIn('id', $cart->cartDiscounts->pluck('discount_id'))
            ->with(DiscountRelations::CONDITIONS);
    }
}
