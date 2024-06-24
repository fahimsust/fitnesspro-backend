<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryRuleRequest;
use Illuminate\Validation\Rules\Enum;
use JMac\Testing\Traits\AdditionalAssertions;
use Support\Enums\MatchAllAnyString;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryRuleRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryRuleRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryRuleRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'match_type' => [new Enum(MatchAllAnyString::class),'required'],
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
