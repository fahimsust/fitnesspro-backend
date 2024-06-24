<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductCostNotBetweenTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_product_cost()
    {
        Product::factory(10)->create(['default_cost'=>50]);
        Product::factory(5)->create(['default_cost'=>150]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DEFAULT_COST_IS_NOT_BETWEEN->value,
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
            ->assertJsonCount(5);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DEFAULT_COST_IS_NOT_BETWEEN->value,
                'min' => 0,
            ]
        )
        ->assertJsonValidationErrorFor('max')
        ->assertStatus(422);
    }
}
