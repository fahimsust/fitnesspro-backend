<?php

namespace Tests\Feature\Domain\Discounts\Models;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Tests\UnitTestCase;

class DiscountConditionTest extends UnitTestCase
{
    private DiscountCondition $discountCondition;

    protected function setUp(): void
    {
        parent::setUp();

        $this->discountCondition = DiscountCondition::factory()->create();
    }

    /** @test */
    public function can_get_type()
    {
        $this->assertInstanceOf(
            DiscountConditionTypes::class,
            $this->discountCondition->type
        );
    }
}
