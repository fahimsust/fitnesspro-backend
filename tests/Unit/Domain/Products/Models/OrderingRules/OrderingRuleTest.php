<?php

namespace Tests\Unit\Domain\Products\Models\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleTranslation;
use Tests\UnitTestCase;

class OrderingRuleTest extends UnitTestCase
{
    private OrderingRule $orderingRule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderingRule = OrderingRule::factory()->create();
    }

    /** @test */
    public function can_get_condition()
    {
        OrderingCondition::factory()->create();
        $this->assertInstanceOf(OrderingCondition::class, $this->orderingRule->conditions()->first());
    }
    /** @test */
    public function can_get_translation()
    {
        OrderingRuleTranslation::factory()->create();
        $this->assertInstanceOf(OrderingRuleTranslation::class, $this->orderingRule->translations()->first());
    }
}
