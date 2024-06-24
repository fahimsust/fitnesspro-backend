<?php

namespace Tests\Feature\Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Actions\FindDiscountIfAvailableByCode;
use Domain\Discounts\Actions\GetAvailableDiscounts;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Discounts\QueryBuilders\AvailableDiscountsQuery;
use Tests\TestCase;
use function collect;
use function now;

class FindDIscountIfAvailableByCodeTest extends TestCase
{
    private DiscountCondition $discountCondition;

    protected function setUp(): void
    {
        parent::setUp();

        $this->discountCondition = DiscountCondition::factory()
            ->create([
                'condition_type_id' => DiscountConditionTypes::REQUIRED_DISCOUNT_CODE,
                'required_code' => 'test'
            ]);

        DiscountAdvantage::factory()->create();
    }

    /** @test */
    public function can_do_simple()
    {
        $found = FindDiscountIfAvailableByCode::run(
            'test'
        );

        $this->assertInstanceOf(Discount::class, $found);
    }
}
