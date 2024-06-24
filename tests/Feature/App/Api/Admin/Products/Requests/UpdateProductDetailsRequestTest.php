<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\UpdateProductDetailsRequest;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdateProductDetailsRequestTest extends ControllerTestCase
{
    use AdditionalAssertions;

    private UpdateProductDetailsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateProductDetailsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'brand_id' => [
                    'int',
                    'exists:' . Brand::Table() . ',id',
                    'nullable'
                ],
                'downloadable' => ['bool', 'nullable'],
                'downloadable_file' => ['string','max:200','nullable'],
                'default_category_id' => [
                    'int',
                    'exists:' . Category::Table() . ',id',
                    'nullable'
                ],
                'create_children_auto' => ['bool', 'nullable'],
                'display_children_grid' => ['bool', 'nullable'],
                'override_parent_description' => ['bool', 'nullable'],
                'allow_pricing_discount' => ['bool', 'nullable']
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
