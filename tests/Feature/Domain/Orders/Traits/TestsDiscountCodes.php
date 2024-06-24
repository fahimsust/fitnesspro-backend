<?php

namespace Tests\Feature\Domain\Orders\Traits;

use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;

trait TestsDiscountCodes
{
    protected DiscountAdvantage $advantage;

    protected function createDiscountCode(string $code)
    {
        DiscountCondition::factory()
            ->create([
                'condition_type_id' => DiscountConditionTypes::REQUIRED_DISCOUNT_CODE,
                'required_code' => $code
            ]);

        $this->advantage = DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::PERCENTAGE_OFF_ORDER,
            'amount' => 10,
        ]);
    }
}
