<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductTranslationBasicsRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTranslationBasicsRequestTest extends ControllerTestCase
{
    use AdditionalAssertions;

    private ProductTranslationBasicsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductTranslationBasicsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string', 'required'],
                'subtitle' => ['string', 'max:255', 'nullable'],
                'url_name' => $this->request->urlRule(),
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
