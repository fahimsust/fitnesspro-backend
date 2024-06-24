<?php

namespace Domain\Discounts\Actions;

use App\Api\Discounts\Exceptions\DiscountCodeHasExpired;
use Domain\Discounts\Models\Discount;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckDiscountDates
{
    use AsObject;

    private Discount $discount;
    private \Illuminate\Support\Carbon $now;

    public function handle(
        Discount $discount
    ) {
        $this->discount = $discount;
        $this->now = now();

        $this->checkStartDate()
            ->checkExpireDate();

        return $this->discount;
    }

    protected function checkStartDate(): static
    {
        if (is_null($this->discount->start_date)) {
            return $this;
        }

        if ($this->discount->start_date >= $this->now) {
            throw new DiscountCodeHasExpired();
        }

        return $this;
    }

    protected function checkExpireDate()
    {
        if (is_null($this->discount->exp_date)) {
            return $this;
        }

        if ($this->discount->exp_date <= $this->now) {
            throw new DiscountCodeHasExpired();
        }

        return $this;
    }
}
