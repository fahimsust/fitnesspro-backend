<?php

namespace Tests\Feature\App\Api\Admin\OrderingConditions\Requests;

use App\Api\Admin\OrderingRules\Requests\OrderingConditionRequest;
use Domain\Products\Enums\OrderingConditionTypes;
use Domain\Products\Models\OrderingRules\OrderingRule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class OrderingConditionRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OrderingConditionRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderingConditionRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'rule_id' => ['numeric', 'exists:' . OrderingRule::Table() . ',id', 'required'],
                'type' => ['string',new Enum(OrderingConditionTypes::class),'required']
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
