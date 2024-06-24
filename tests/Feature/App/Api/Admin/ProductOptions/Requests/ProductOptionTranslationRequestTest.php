<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Requests;

use App\Api\Admin\ProductOptions\Requests\ProductOptionTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductOptionTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductOptionTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductOptionTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string', 'max:100', 'required'],
                'display' => ['string', 'max:100', 'required'],
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
