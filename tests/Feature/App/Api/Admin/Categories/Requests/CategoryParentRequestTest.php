<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryParentRequest;
use Domain\Products\Models\Category\Category;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryParentRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryParentRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryParentRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'parent_id' => ['numeric', 'exists:' . Category::Table() . ',id', 'nullable'],
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
