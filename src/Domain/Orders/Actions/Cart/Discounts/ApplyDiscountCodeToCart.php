<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use App\Api\Orders\Exceptions\DiscountCodeAlreadyApplied;
use App\Api\Orders\Exceptions\MaxDiscountsPerOrderReached;
use Domain\Accounts\Models\Account;
use Domain\Discounts\Actions\AbstractApplyDiscountCodeAction;
use Domain\Discounts\Actions\FindDiscountIfAvailableByCode;
use Domain\Discounts\Collections\DiscountCollection;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\ValueObjects\ToBeAppliedDiscountData;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyDiscountCodeToCart extends AbstractApplyDiscountCodeAction
{
    use AsObject;

    public Cart $cart;

    protected ?CartDiscount $cartDiscount = null;
    private string $discountCode;
    private Carbon $now;
    private Discount $foundDiscount;
    private ?CartDiscountCode $appliedDiscountCode = null;

    public function handle(
        string   $discountCode,
        Cart     $cart,
        ?Account $account = null
    ): ?CartDiscountCode
    {
        $this->cart = $cart;
        $this->discountCode = $discountCode;

        $this->checkMaxDiscountCodesPerOrder()
            ->checkIfDiscountCodeAlreadyApplied();

        $this->foundDiscount = FindDiscountIfAvailableByCode::run(
            $this->discountCode,
            $account
        );

        CheckDiscountsForCart::run(
            new DiscountCollection([$this->foundDiscount]),
            cart: $cart,
            account: $account,
        )->first(
            function (ToBeAppliedDiscountData $toApplyDiscount) {
                $this->applyDiscount(
                    $toApplyDiscount->discount
                );
            }
        );

        return $this->appliedDiscountCode;
    }

    protected function applyDiscount(Discount $discount): void
    {
        $this->appliedDiscountCode = ApplyDiscountToCart::run(
            $this->cart,
            $discount,
        )
            ->cartDiscount
            ->codes()
            ->create([
                'code' => $this->discountCode,
                'condition_id' => $this->foundDiscount
                    ->rules
                    ->map(
                        fn(DiscountRule $rule) => $rule->conditions
                            ->firstWhere('required_code', $this->discountCode)
                    )
                    ->first()
                    ->id,
            ]);
    }

    protected function checkMaxDiscountCodesPerOrder(): static
    {
        if (
            config('discounts.limit_discount_codes_per_order') > 0
            && $this->cart->discountCodes()
                ->with('condition')
                ->count() >= config('discounts.limit_discount_codes_per_order')
        ) {
            throw new MaxDiscountsPerOrderReached();
        }

        return $this;
    }

    protected function checkIfDiscountCodeAlreadyApplied(): static
    {
        $exists = $this->cart->discountCodes->firstWhere(
            fn(CartDiscountCode $cartDiscountCode) => $cartDiscountCode
                    ->condition->required_code === $this->discountCode
        );

        if (!is_null($exists)) {
            throw new DiscountCodeAlreadyApplied();
        }

        return $this;
    }
}
