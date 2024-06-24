<?php

namespace Tests\Feature\App\Api\Admin\ProductTypes\Requests;

use App\Api\Admin\Products\Types\Requests\ProductTypeRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTypeRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductTypeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductTypeRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:55','required']
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
