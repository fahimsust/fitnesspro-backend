<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionCustom;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderProductControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_product()
    {
        $product = Product::factory()->create();
        ProductAccessory::factory()->create();
        ProductOption::factory()->create();
        ProductOptionValue::factory()->create();
        ProductOptionCustom::factory()->create();

        $response = $this->getJson(route('admin.product.order-product', [$product]))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'title',
                'details',
                'accessories' => [
                    '*' => [
                        'id',
                        'title',
                        'options' => [
                            '*' => [
                                'id',
                                'type_id',
                                'option_values' => [
                                    '*' => [
                                        'id',
                                        'name',
                                        'custom' => [
                                            'custom_type',
                                            'custom_label'
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'options' => [
                    '*' => [
                        'id',
                        'type_id',
                        'option_values' => [
                            '*' => [
                                'id',
                                'name',
                                'custom' => [
                                    'custom_type',
                                    'custom_label'
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }

}
