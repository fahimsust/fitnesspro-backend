<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductCombinedStockBetweenTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_product_stock()
    {
        Product::factory(10)->create(['combined_stock_qty'=>50]);
        Product::factory(5)->create(['combined_stock_qty'=>150]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::COMBINED_STOCK_QUANTITY_IS_BETWEEN->value,
                'min' => 0,
                'max' => 100,
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
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::COMBINED_STOCK_QUANTITY_IS_BETWEEN->value,
                'min' => 0,
            ]
        )
        ->assertJsonValidationErrorFor('max')
        ->assertStatus(422);
    }
}
