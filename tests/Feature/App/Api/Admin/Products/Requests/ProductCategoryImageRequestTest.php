<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductCategoryImageRequest;
use App\Api\Admin\Products\Requests\ProductDetailsImageRequest;
use Domain\Content\Models\Image;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductCategoryImageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductCategoryImageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductCategoryImageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'category_img_id' => [
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
