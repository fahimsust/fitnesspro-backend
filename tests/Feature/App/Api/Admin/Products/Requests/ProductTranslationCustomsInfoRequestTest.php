<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductCustomsInfoRequest;
use App\Api\Admin\Products\Requests\ProductTranslationCustomsInfoRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTranslationCustomsInfoRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductTranslationCustomsInfoRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ProductTranslationCustomsInfoRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'customs_description' => ['string','max:255', 'nullable'],
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
