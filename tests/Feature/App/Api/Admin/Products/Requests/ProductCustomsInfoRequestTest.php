<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductCustomsInfoRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductCustomsInfoRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductCustomsInfoRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ProductCustomsInfoRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'customs_description' => ['string','max:255', 'nullable'],
                'tariff_number' => ['string','max:55', 'nullable'],
                'country_origin' => ['string','max:20', 'nullable']
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
