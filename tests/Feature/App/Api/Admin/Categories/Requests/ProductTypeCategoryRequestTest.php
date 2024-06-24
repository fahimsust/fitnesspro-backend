<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryProducTypeRequest;
use Domain\Products\Models\Product\ProductType;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTypeCategoryRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryProducTypeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryProducTypeRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'type_id' => ['numeric', 'exists:' . ProductType::Table() . ',id', 'required'],
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
