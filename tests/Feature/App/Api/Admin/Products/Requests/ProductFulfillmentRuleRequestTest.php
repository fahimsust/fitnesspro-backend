<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductFulfillmentRuleRequest;
use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductFulfillmentRuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductFulfillmentRuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductFulfillmentRuleRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'fulfillment_rule_id' => [
                    'int',
                    'exists:' . FulfillmentRule::Table() . ',id',
                    'nullable'
                ]
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
