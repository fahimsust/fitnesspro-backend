<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductNotInventoriedTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_inventoried()
    {
        Product::factory(10)->create(['inventoried'=>1]);
        Product::factory(5)->create(['inventoried'=>0]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::IS_NOT_INVENTORIED->value,
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
}
