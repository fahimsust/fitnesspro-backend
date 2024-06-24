<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\AddProductToOrderPackageRequest;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Products\Models\Product\Product;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AddProductToOrderPackageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AddProductToOrderPackageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AddProductToOrderPackageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $product = Product::factory()->create();
        $package = OrderPackage::factory()->create();
        $this->request->merge([
            'child_product_id' => $product->id,
            'package_id' => $package->id
        ]);

        $rules = [
            'child_product_id' => ['required', 'exists:' . Product::Table() . ',id'],
            'package_id' => ['required', 'exists:' . OrderPackage::Table() . ',id'],
            'qty' => ['required', 'int', 'min:1'],
            'custom_field_values' => ['nullable', 'array'],
            'accessories' => ['nullable', 'array'],
        ];
        if ($this->request->hasProductOptions()) {
            $rules['option_custom_values'] = ['nullable', 'array'];
            $rules['option_custom_values.*.option_value_id'] = ['int'];
            $rules['option_custom_values.*.custom_value'] = ['nullable', 'string'];
        }

        $this->assertEquals(
            $rules,
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
