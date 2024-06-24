<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductAddToCartSettingsRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class ProductAddToCartSettingsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductAddToCartSettingsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ProductAddToCartSettingsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'addtocart_external_label' => ['string','max:255', 'nullable'],
                'addtocart_external_link' => ['string','max:255', 'nullable'],
                'addtocart_setting' => ['int',Rule::in([0,1,2]), 'nullable']
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
