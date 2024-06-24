<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductMetaDataRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductMetaDataRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductMetaDataRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ProductMetaDataRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'meta_title' => ['string','max:155', 'nullable'],
                'meta_desc' => ['string','max:255', 'nullable'],
                'meta_keywords' => ['string','max:255', 'nullable']
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
