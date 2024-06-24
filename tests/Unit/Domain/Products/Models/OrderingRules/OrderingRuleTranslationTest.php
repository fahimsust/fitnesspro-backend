<?php

namespace Tests\Unit\Domain\Products\Models\OrderingRules;

use Domain\Locales\Models\Language;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleTranslation;
use Tests\UnitTestCase;

class OrderingRuleTranslationTest extends UnitTestCase
{
    private OrderingRuleTranslation $orderingRuleTranslation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderingRuleTranslation = OrderingRuleTranslation::factory()->create();
    }

    /** @test */
    public function can_get_ordering_rule()
    {
        $this->assertInstanceOf(OrderingRule::class,$this->orderingRuleTranslation->orderingRule);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->orderingRuleTranslation->language);
    }
}
