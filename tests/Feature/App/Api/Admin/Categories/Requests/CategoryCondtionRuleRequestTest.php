<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryCondtionRuleRequest;
use Domain\Products\Models\Attribute\AttributeOption;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryCondtionRuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryCondtionRuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryCondtionRuleRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'matches' => ['bool','required'],
                'value_id' => ['numeric', 'exists:' . AttributeOption::Table() . ',id', 'required'],
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
