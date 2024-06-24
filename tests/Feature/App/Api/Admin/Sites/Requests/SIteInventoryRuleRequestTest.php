<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteInventoryRuleRequest;
use Domain\Sites\Models\InventoryRule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SIteInventoryRuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteInventoryRuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new SiteInventoryRuleRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'rule_id' => ['numeric', 'exists:' . InventoryRule::Table() . ',id', 'required']
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
