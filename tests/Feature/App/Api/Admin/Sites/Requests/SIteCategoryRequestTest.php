<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteCategoryRequest;
use Domain\Products\Models\Category\Category;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SIteCategoryRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteCategoryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new SiteCategoryRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'category_id' => ['numeric', 'exists:' . Category::Table() . ',id', 'required']
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
