<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductStatusIsTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_status()
    {
        Product::factory(10)->create(['status'=>1]);
        Product::factory(5)->create(['status'=>0]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::STATUS_IS->value,
                'status' => 1,
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
                'search_option' => SearchOptions::STATUS_IS->value,
            ]
        )
        ->assertJsonValidationErrorFor('status')
        ->assertStatus(422);
    }
}
