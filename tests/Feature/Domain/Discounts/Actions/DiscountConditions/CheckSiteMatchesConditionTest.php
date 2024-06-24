<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Actions\DiscountConditions\CheckSiteMatchesCondition;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Sites\Models\Site;
use Tests\TestCase;

class CheckSiteMatchesConditionTest extends TestCase
{
    /** @test */
    public function check_site()
    {
        $condition = DiscountCondition::factory()
            ->create(['condition_type_id' => DiscountConditionTypes::REQUIRED_SITE]);
        $site = Site::factory()->create(['id' => config('site.id')]);
        ConditionSite::factory()->create(['site_id' => config('site.id')]);

        $checkActiveMembershipLevel = (new CheckSiteMatchesCondition(
            new DiscountCheckerData(),
            $condition
        ))
            ->site($site);

        $this->assertTrue($checkActiveMembershipLevel->check());
    }
}
