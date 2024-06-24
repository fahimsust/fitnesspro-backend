<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryProductRequest;
use Domain\Products\Models\Product\Product;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryProductRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryProductRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'product_id' => ['numeric', 'exists:' . Product::Table() . ',id', 'required'],
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
