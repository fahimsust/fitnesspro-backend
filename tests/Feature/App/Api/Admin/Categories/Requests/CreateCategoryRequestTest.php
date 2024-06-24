<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Models\Category\Category;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateCategoryRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateCategoryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateCategoryRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string','max:255', 'required'],
                'subtitle' => ['string', 'max:155', 'nullable'],
                'url_name' => $this->request->urlRule(),
                'parent_id' => ['numeric', 'exists:' . Category::Table() . ',id', 'nullable'],
                'description' => ['string','nullable'],
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
