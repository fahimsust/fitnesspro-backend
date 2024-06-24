<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Requests;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

class OrderingRuleTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OrderingRuleTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderingRuleTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:85', 'required'],
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
