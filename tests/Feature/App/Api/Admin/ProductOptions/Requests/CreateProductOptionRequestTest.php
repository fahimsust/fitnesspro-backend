<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Requests;

use App\Api\Admin\ProductOptions\Requests\CreateProductOptionRequest;
use App\Api\Admin\ProductOptions\Rules\IsParentProduct;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Product;
use Illuminate\Validation\Rules\Enum;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateProductOptionRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateProductOptionRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateProductOptionRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string', 'max:100', 'required'],
                'display' => ['string', 'max:100', 'required'],
                'type_id' => [
                    'numeric',
                    new Enum(ProductOptionTypes::class),
                    'required'
                ],
                'product_id' => [
                    'numeric',
                    'exists:' . Product::Table() . ',id',
                    new IsParentProduct,
                    'required'
                ]
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
