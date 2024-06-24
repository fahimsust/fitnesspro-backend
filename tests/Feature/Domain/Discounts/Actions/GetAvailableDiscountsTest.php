<?php

namespace Tests\Feature\Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Actions\GetAvailableDiscounts;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Discounts\QueryBuilders\AvailableDiscountsQuery;
use Tests\TestCase;
use function collect;
use function now;

class GetAvailableDiscountsTest extends TestCase
{
    private DiscountCondition $discountCondition;
    private DiscountAdvantage $discountAdvantage;
    private Discount $discount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->discount = Discount::firstOrFactory();
        $rule = DiscountRule::factory()
            ->for($this->discount)
            ->create();
        $this->discountCondition = DiscountCondition::factory()
            ->for($rule, 'rule')
            ->create();
        $this->discountAdvantage = DiscountAdvantage::factory()
            ->for($this->discount)
            ->create();
    }

    /** @todo */
    public function can_do_simple()
    {
        $discounts = GetAvailableDiscounts::run(
            new AvailableDiscountsQuery
        );

        $this->assertCount(1, $discounts);
        $this->assertInstanceOf(Discount::class, $discounts->first());
    }

    /** @todo */
    public function can_do_date()
    {
        $this->discount->update([
            'exp_date' => now()->subDays(5)
        ]);

        $discounts = GetAvailableDiscounts::run();

        $this->assertCount(0, $discounts);

        $this->discount->update([
            'exp_date' => now()->addDays(5)
        ]);

        $discounts = GetAvailableDiscounts::run();

        $this->assertCount(1, $discounts);
        $this->assertInstanceOf(Discount::class, $discounts->first());
    }

    /** @test */
    public function can_exclude_ids()
    {
        $discounts = GetAvailableDiscounts::run(
            (new AvailableDiscountsQuery)
                ->excludeDiscountIds(collect($this->discount->id))
        );

        $this->assertCount(0, $discounts);
    }

    /** @todo */
    public function can_include_account()
    {
        $this->discount->update([
            'limit_per_customer' => 1
        ]);

        $account = Account::firstOrFactory();
        $discounts = GetAvailableDiscounts::run(account: $account);

        $this->assertCount(1, $discounts);
        $this->assertInstanceOf(Discount::class, $discounts->first());

        //set to limit to confirm it won't return
        AccountUsedDiscount::factory()->create([
            'times_used' => 1
        ]);

        $this->assertCount(0, GetAvailableDiscounts::run(account: $account));
    }
}
