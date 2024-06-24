<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductCategoryNotMatchTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_category()
    {
        $products = Product::factory(10)->create();
        $category = Category::factory()->create();
        $category2 = Category::factory()->create();

        ProductDetail::factory()->create(['default_category_id' => $category->id, 'product_id' => $products[0]->id]);
        ProductDetail::factory()->create(['default_category_id' => $category->id, 'product_id' => $products[1]->id]);
        foreach ($products as $key => $product) {
            if ($key > 1) {
                ProductDetail::factory()->create(['default_category_id' => $category2->id, 'product_id' => $product->id]);
            }
        }
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DEFAULT_CATEGORY_IS_NOT->value,
                'category_id' => $category->id,
            ]
        )
        ->assertOk()
        ->assertJsonStructure([
            '*' => [
                'id',
                'title',
            ]
        ])
        ->assertJsonCount(8);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DEFAULT_CATEGORY_IS_NOT->value,
            ]
        )
            ->assertJsonValidationErrorFor('category_id')
            ->assertStatus(422);
    }
}
