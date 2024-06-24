<?php

namespace Domain\Discounts\Actions;

use App\Api\Discounts\Exceptions\DiscountCodeNotFound;
use App\Api\Discounts\Exceptions\MaxUseLimitForDiscountReached;
use Domain\Accounts\Models\Account;
use Domain\Discounts\Enums\DiscountRelations;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\QueryBuilders\AvailableDiscountsQuery;
use Lorisleiva\Actions\Concerns\AsObject;

class FindDiscountIfAvailableByCode
{
    use AsObject;

    private Discount $foundDiscount;

    public function handle(
        string $discountCode,
        ?Account $account = null
    ): Discount {
        $this->find($account, $discountCode)
            ->checkUseLimit();

        CheckDiscountDates::run($this->foundDiscount);

        return $this->foundDiscount;
    }

    protected function find(?Account $account, string $discountCode): static
    {
        $this->foundDiscount = GetAvailableDiscounts::run(
            (new AvailableDiscountsQuery())
                ->includeAccount($account, false)
                ->with(DiscountRelations::CONDITIONS)
                ->where('required_code', $discountCode)
        )->first()
            ?? throw new DiscountCodeNotFound();

        return $this;
    }

    protected function checkUseLimit(): static
    {
        if (is_null($this->foundDiscount->discount_used)) {
            return $this;
        }

        if ($this->foundDiscount->discount_used >= $this->foundDiscount->limit_per_customer) {
            throw new MaxUseLimitForDiscountReached();
        }

        return $this;
    }
}
