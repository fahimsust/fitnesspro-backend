<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Requests;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\MatchAllAnyString;

class OrderingRuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OrderingRuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OrderingRuleRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:85', 'required'],
                'any_all' => ['string',new Enum(MatchAllAnyString::class)]
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
