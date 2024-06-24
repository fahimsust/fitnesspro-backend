<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductByIsChildTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_child()
    {
        $product = Product::factory()->create();
        Product::factory(10)->create(['parent_product'=>$product->id]);
        Product::factory(5)->create(['parent_product'=>null]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::IS_CHILD->value,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(10);
    }
}
