<?php

namespace Tests\Feature\App\Api\Admin\PricingRules\Controllers;

use Domain\Products\Models\Product\Pricing\PricingRule;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PricingRuleControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_all_pricing_rules()
    {
        PricingRule::factory(30)->create();

        $this->getJson(route('admin.pricing-rule.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])->assertJsonCount(30);
    }


}
