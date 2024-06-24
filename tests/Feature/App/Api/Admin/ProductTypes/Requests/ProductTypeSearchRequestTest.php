<?php

namespace Tests\Feature\App\Api\Admin\ProductTypes\Requests;

use App\Api\Admin\Products\Types\Requests\ProductTypeSearchRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTypeSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductTypeSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductTypeSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
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
