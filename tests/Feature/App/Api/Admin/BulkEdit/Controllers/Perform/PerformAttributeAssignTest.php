<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetAttribute;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformAttributeAssignTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_attribute()
    {
        $products = Product::factory(10)->create();
        $attributeSets = AttributeSet::factory(2)->create();
        $attributes = Attribute::factory(30)->create();
        foreach ($attributes as $key => $value) {
            if ($key < 6) {
                AttributeSetAttribute::factory()->create(['attribute_id' => $value->id, 'set_id' => $attributeSets[0]->id]);
            } else {
                AttributeSetAttribute::factory()->create(['attribute_id' => $value->id, 'set_id' => $attributeSets[1]->id]);
            }
        }
        foreach ($attributes as $key => $value) {
            $options = AttributeOption::factory(10)->create(['attribute_id' => $value->id]);
            if ($key < 4) {
                foreach ($products as $product)
                    ProductAttribute::factory()->create(['option_id' => $options[rand(0, 9)]->id, 'product_id' => $product->id]);
            }
        }
        $options = [];
        foreach ($attributes as $key => $value) {
            if ($key < 6) {
                $options[] = AttributeOption::factory()->create(['attribute_id' => $value->id])->id;
            }
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_ATTRIBUTES,
                'attributeList' => $options,
                'set' => $attributeSets[0]->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertDatabaseCount(ProductAttribute::Table(), 60);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $attributeSet = AttributeSet::factory()->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_ATTRIBUTES,
                'ids' => $products->pluck('id')->toArray(),
                'set' => $attributeSet->id,
            ]
        )
            ->assertJsonValidationErrorFor('attributeList')
            ->assertStatus(422);
    }
}
