<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductDetailsRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductDetailsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductDetailsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductDetailsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'summary' => ['string', 'required'],
                'description' => ['string', 'required'],
                'product_attributes' => ['string', 'nullable']
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
