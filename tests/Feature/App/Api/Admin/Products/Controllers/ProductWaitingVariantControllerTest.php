<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Actions\ProductOptions\GetCombosAwaitingVariant;
use Domain\Products\Models\Product\Product;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestProductUtilities;
use function route;

class ProductWaitingVariantControllerTest extends ControllerTestCase
{
    use TestProductUtilities;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->createProductWithOptionValues();
    }

    /** @test */
    public function can_get_product_awaiting_variant()
    {
        $this->getJson(route('admin.product.product-awaiting-variant.index', [$this->product]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'ids',
                        'display'
                    ]
                ]
            )
            ->assertJsonCount(4);
    }

    /** @test */
    public function can_create_product_variant()
    {
        $option_values = GetCombosAwaitingVariant::run($this->product)->take(2)->toArray();

        $this->postJson(
            route('admin.product.product-awaiting-variant.store', [$this->product]),
            [
                'option_values' => $option_values
            ]
        )
            ->assertOk();

        $this->assertDatabaseCount(Product::Table(), 3);
    }
}
