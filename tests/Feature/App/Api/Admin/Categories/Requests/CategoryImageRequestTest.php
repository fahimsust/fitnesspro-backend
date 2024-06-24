<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryImageRequest;
use Domain\Content\Models\Image;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryImageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryImageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryImageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'image_id' => ['numeric', 'exists:' . Image::Table() . ',id', 'nullable'],
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
