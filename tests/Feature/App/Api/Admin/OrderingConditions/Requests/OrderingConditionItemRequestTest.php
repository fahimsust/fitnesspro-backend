<?php

namespace Tests\Feature\App\Api\Admin\OrderingConditions\Requests;

use App\Api\Admin\OrderingRules\Requests\OrderingConditionItemRequest;
use App\Rules\ExistsInModels;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Specialty;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class OrderingConditionItemRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OrderingConditionItemRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderingConditionItemRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'item_id' => ['numeric', 'required',new ExistsInModels([Specialty::Table(),AccountType::Table()])],
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
