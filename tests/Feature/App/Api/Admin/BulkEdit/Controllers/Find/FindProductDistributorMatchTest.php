<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductDistributorMatchTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_distributor()
    {
        $distributor = Distributor::factory()->create();
        $distributor2 = Distributor::factory()->create();
        Product::factory(10)->create(['default_distributor_id'=>$distributor->id]);
        Product::factory(5)->create(['default_distributor_id'=>$distributor2->id]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DEFAULT_DISTRIBUTOR_IS->value,
                'distributor_id' => $distributor->id,
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
                'search_option' => SearchOptions::DEFAULT_DISTRIBUTOR_IS->value,
            ]
        )
        ->assertJsonValidationErrorFor('distributor_id')
        ->assertStatus(422);
    }
}
