<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Actions\CheckDiscountLimitPerPurchase;
use Domain\Discounts\Actions\CheckDiscounts;
use Domain\Discounts\Collections\DiscountCollection;
use Domain\Discounts\Collections\ToBeAppliedDiscountCollection;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Traits\HasExceptionCollection;

class CheckDiscountsForCart
{
    use AsObject,
        HasExceptionCollection;

    public Collection $failedDiscounts;
    public Collection $readyToApplyDiscounts;
    public CheckDiscounts $checkedDiscounts;

    public function handle(
        DiscountCollection|Collection $discounts,
        Cart $cart,
        ?Account $account = null,
    ): ToBeAppliedDiscountCollection {
        $this->failedDiscounts = collect();
        $this->readyToApplyDiscounts = new ToBeAppliedDiscountCollection();

        if (!$discounts->count()) {
            return $this->readyToApplyDiscounts;
        }

        $this->checkedDiscounts = (new CheckDiscounts(
            $discounts,
            cart: $cart,
            account: $account,
        ))
            ->handle();

        $this->handleFailed($cart, $this->checkedDiscounts->failed());
        $this->handledPassed($cart, $this->checkedDiscounts->passed());

        return $this->readyToApplyDiscounts;
    }

    protected function handleFailed(Cart $cart, Collection $failed): void
    {
        if (!$failed->count()) {
            return;
        }

        $cart->cartDiscounts()
            ->whereIn(
                'discount_id',
                $failed->map(
                    fn (Discount $discount) => $discount->id
                )
                    ->toArray()
            )
            ->delete();

        $this->failedDiscounts = $failed;
    }

    protected function handledPassed(Cart $cart, Collection $passed): void
    {
        if (!$passed->count()) {
            return;
        }

        //get count for number of times each passed discount has applied
        $applied = $cart->cartDiscounts()
            ->whereIn(
                'discount_id',
                $passed->map(
                    fn (Discount $discount) => $discount->id
                )->toArray()
            )
            ->get()
            ->mapWithKeys(
                fn (CartDiscount $cartDiscount) => [
                    $cartDiscount->discount_id => $cartDiscount->applied,
                ]
            );


        //run limit check
        $passed->each(
            fn (Discount $discount) => $this->checkDiscountPerOrderLimit(
                $discount,
                $applied->get($discount->id) ?? 0
            )
        );
    }

    private function checkDiscountPerOrderLimit(
        Discount $discount,
        int $alreadyAppliedCount = 0
    ): void {
        try {
            $this->readyToApplyDiscounts->push(
                CheckDiscountLimitPerPurchase::run(
                    $discount,
                    $alreadyAppliedCount
                )
            );
        } catch (\Exception $exception) {
            $this->catchToCollection($exception);

            $this->failedDiscounts->push($discount);
        }
    }
}
