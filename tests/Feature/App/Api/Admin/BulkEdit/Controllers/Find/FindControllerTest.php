<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FindControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_get_option()
    {
        $this->getJson(route('admin.bulk-edit-find.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(count(SearchOptions::cases()));
    }

    /** @test */
    public function can_search_product_for_parent_id()
    {
        $product = Product::factory()->create();
        Product::factory(100)->create([
            'parent_product'=>$product->id
        ]);

        $this->postJson(route('admin.bulk-edit-find.store'),
                [
                    'search_option' => SearchOptions::PARENT_PRODUCT_ID->value,
                    'value'=>$product->id,
                ]
            )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(100);
    }
    /** @test */
    public function can_search_product_by_keyword_exists()
    {
        $product = Product::factory()->create();
        Product::factory(100)->create([
            'parent_product'=>$product->id
        ]);

        $this->postJson(route('admin.bulk-edit-find.store'),
                [
                    'search_option' => SearchOptions::PARENT_PRODUCT_ID->value,
                    'value'=>$product->id,
                ]
            )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(100);
    }
}
