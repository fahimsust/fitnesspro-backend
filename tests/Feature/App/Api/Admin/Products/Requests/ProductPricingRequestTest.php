<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductPricingRequest;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Sites\Models\Site;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductPricingRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductPricingRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductPricingRequest();
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
                'pricing_rule_id' => ['int', 'exists:' . PricingRule::Table() . ',id', 'nullable'],
                'ordering_rule_id' => ['int', 'exists:' . OrderingRule::Table() . ',id', 'nullable'],
                'status' => ['bool', 'nullable'],
                'price_reg' => ['numeric','required'],
                'price_sale' => ['numeric', 'nullable','lte:price_reg'],
                'onsale' => ['bool', 'required'],
                'min_qty' => ['numeric', 'nullable','lte:max_qty'],
                'max_qty' => ['numeric','nullable'],
                'feature' => ['bool', 'required'],
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
