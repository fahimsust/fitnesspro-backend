<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductTranslationDetailsRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTranslationDetailsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductTranslationDetailsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductTranslationDetailsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'summary' => ['string', 'required'],
                'description' => ['string', 'required'],
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
