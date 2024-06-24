<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\ProductAttribute;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestProductTypeAttribute;
use function route;

class ProductAttributeControllerTest extends ControllerTestCase
{
    use TestProductTypeAttribute;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->createProductTypeAttributeWithOption();
    }

    /** @test */
    public function can_get_product_attribute_options()
    {
        $this->getJson(route('admin.product-attribute.index', ['product_id' => $this->product->id]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'attribute_sets' => [
                        '*' =>
                            [
                                'attributes' => [
                                    '*' => ['options', 'selected']
                                ]
                            ]
                    ]
                ]
            );
    }

    /** @test */
    public function can_add_product_attribute_option()
    {
        $option = AttributeOption::factory()->create();

        $this->postJson(
            route('admin.product-attribute.store'),
            ['product_id' => $this->product->id, 'option_ids' => [$option->id], 'attribute_id' => $option->attribute_id]
        )
            ->assertCreated();

        $this->assertDatabaseCount(ProductAttribute::Table(), 10);

        $this->postJson(
            route('admin.product-attribute.store'),
            ['product_id' => $this->product->id, 'option_ids' => [], 'attribute_id' => $option->attribute_id]
        )
            ->assertCreated();

        $this->assertDatabaseCount(ProductAttribute::Table(), 9);
    }

    /** @test */
    public function can_delete_product_attribute_option()
    {
        $productAttribute = ProductAttribute::first();
        $this->deleteJson(route('admin.product-attribute.destroy', $productAttribute))
            ->assertOk();

        $this->assertDatabaseCount(ProductAttribute::Table(), 9);
    }
}
