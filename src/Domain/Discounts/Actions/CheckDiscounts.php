<?php

namespace Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Collections\DiscountCollection;
use Domain\Discounts\Contracts\CanBeCheckedForDiscount;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\Cart;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Traits\HasExceptionCollection;

class CheckDiscounts
{
    use AsObject,
        HasExceptionCollection;

    public CanBeCheckedForDiscount|DiscountCollection $discountEntity;

    public Collection $failedDiscounts;
    public Collection $passedDiscounts;
    public DiscountCheckerData $checkerData;

    public function __construct(
        public DiscountCollection|Collection $discounts,
        public ?Cart $cart = null,
        public ?Account $account = null,
    ) {
        $this->failedDiscounts = collect();
        $this->passedDiscounts = collect();

        $this->checkerData = new DiscountCheckerData();
    }

    public function handle(): static
    {
        if (! $this->discounts->count()) {
            throw new \Exception(__('No discounts provided to check'));
        }

        $this->discounts
            ->each(
                function (Discount $discount) {
                    try {
                        $this->passedDiscounts->push(
                            $this->check($discount)
                        );
                    } catch (\Exception $exception) {
                        $this->failedDiscounts->push(
                            $discount
                        );

                        $this->catchToCollection($exception);
                    }
                }
            );

        return $this;
    }

    public function failed(): Collection
    {
        return $this->failedDiscounts;
    }

    public function passed(): Collection
    {
        return $this->passedDiscounts;
    }

    private function check(Discount $discount): Discount
    {
        (new CheckDiscountRules(
            checkerData: $this->checkerData,
            discountEntity: $discount,
            cart: $this->cart,
            account: $this->account,
        ))
            ->handle();

        return $discount;
    }
}
