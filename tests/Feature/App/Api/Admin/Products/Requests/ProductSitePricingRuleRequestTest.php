<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductSitePricingRuleRequest;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Sites\Models\Site;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

class ProductSitePricingRuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductSitePricingRuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductSitePricingRuleRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'site_id' => [
                    'int',
                    'exists:' . Site::Table() . ',id',
                    'nullable'
                ],
                'pricing_rule_id' => ['int', 'exists:' . PricingRule::Table() . ',id', 'nullable']
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->createAndAuthAdminUser();

        $this->assertTrue($this->request->authorize());
    }
}
