<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\CreateProductRequest;
use App\Api\Admin\Products\Requests\ProductBasicsRequest;
use Domain\Distributors\Models\Distributor;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateProductRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateProductRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string', 'required'],
                'subtitle' => ['string', 'max:255', 'nullable'],
                'url_name' => (new ProductBasicsRequest)->urlRule(),
                'default_distributor_id' => [
                    'int',
                    'exists:' . Distributor::Table() . ',id',
                    'nullable',
                ],
                'product_no' => ['string', 'max:155', 'nullable'],
                'weight' => ['int', 'nullable'],
                'price_reg' => ['numeric','required'],
                'price_sale' => ['numeric', 'nullable','lte:price_reg'],
                'onsale' => ['bool', 'required'],
                'min_qty' => ['numeric', 'nullable','lte:max_qty'],
                'max_qty' => ['numeric','nullable'],
                'feature' => ['bool', 'required'],
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
