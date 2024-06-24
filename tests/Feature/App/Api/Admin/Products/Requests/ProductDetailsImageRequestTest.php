<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductDetailsImageRequest;
use Domain\Content\Models\Image;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductDetailsImageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductDetailsImageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductDetailsImageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'details_img_id' => [
                    'int',
                    'exists:' . Image::Table() . ',id',
                    'nullable',
                ]
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
