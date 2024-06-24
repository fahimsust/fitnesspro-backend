<?php

namespace Tests\Unit\Domain\Discounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class DiscountTest extends TestCase
{
    protected Model|Discount $discount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->discount = Discount::factory()->create();
    }

    /** @test */
    public function can_get_used_by_accounts()
    {
        AccountUsedDiscount::factory()->create();

        $this->assertCount(1, $this->discount->usedByAccounts);
        $this->assertInstanceOf(
            Account::class,
            $this->discount->usedByAccounts->first()
        );
    }

    /** @test */
    public function can_get_account_uses()
    {
        AccountUsedDiscount::factory()->create();

        $this->assertCount(1, $this->discount->accountUses);
        $this->assertInstanceOf(
            AccountUsedDiscount::class,
            $this->discount->accountUses->first()
        );
    }
}
