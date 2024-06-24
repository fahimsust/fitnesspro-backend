<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformDefaultCategoryUpdateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_product_type()
    {
        $category = Category::factory(2)->create();
        $products = Product::factory(10)->create();
        foreach($products as $product)
        {
            ProductDetail::factory()->create(['product_id'=>$product->id,'default_category_id'=>$category[0]->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_DEFAULT_CATEGORY,
                'category_id' => $category[1]->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($category[1]->id, ProductDetail::first()->default_category_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_DEFAULT_CATEGORY,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('category_id')
        ->assertStatus(422);
    }
}
