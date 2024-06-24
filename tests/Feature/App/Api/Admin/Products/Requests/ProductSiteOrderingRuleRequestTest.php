<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductSiteOrderingRuleRequest;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Sites\Models\Site;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

class ProductSiteOrderingRuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductSiteOrderingRuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductSiteOrderingRuleRequest();
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
                'ordering_rule_id' => ['int', 'exists:' . OrderingRule::Table() . ',id', 'nullable'],
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
