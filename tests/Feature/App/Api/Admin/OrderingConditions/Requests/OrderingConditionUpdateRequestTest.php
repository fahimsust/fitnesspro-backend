<?php

namespace Tests\Feature\App\Api\Admin\OrderingConditions\Requests;

use App\Api\Admin\OrderingRules\Requests\OrderingConditionUpdateRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\MatchAllAnyString;

class OrderingConditionUpdateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OrderingConditionUpdateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderingConditionUpdateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'any_all' => ['string',new Enum(MatchAllAnyString::class), 'required'],
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
