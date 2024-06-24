<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteCategoryFilterRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class SiteCategoryFilterRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteCategoryFilterRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SiteCategoryFilterRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'filter_categories' => ['int','required', Rule::in([0,1,2]),],
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
