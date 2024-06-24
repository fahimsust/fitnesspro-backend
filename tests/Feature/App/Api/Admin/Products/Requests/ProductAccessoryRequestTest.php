<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductAccessoryRequest;
use App\Rules\IsCompositeUnique;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductAccessoryRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductAccessoryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductAccessoryRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'accessory_id' => [
                    'int',
                    'exists:' . Product::Table() . ',id',
                    'required'
                ],
                'required' => ['bool', 'nullable'],
                'show_as_option' => ['bool', 'nullable'],
                'discount_percentage' => ['integer','max:100','min:0', 'nullable'],
                'link_actions' => ['bool', 'nullable'],
                'description' => ['string', 'max:255', 'nullable'],
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
