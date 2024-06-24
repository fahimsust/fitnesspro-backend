<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductByDisocuntLevelTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_disocunt_level()
    {
        $products = Product::factory(10)->create();
        $disocuntLevel = DiscountLevel::factory()->create();
        DiscountLevelProduct::factory()->create(['discount_level_id'=>$disocuntLevel->id,'product_id'=>$products[0]->id]);
        DiscountLevelProduct::factory()->create(['discount_level_id'=>$disocuntLevel->id,'product_id'=>$products[1]->id]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::ASSIGNED_TO_DISCOUNT_LEVEL->value,
                'discount_level_id' => $disocuntLevel->id,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(2);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::ASSIGNED_TO_DISCOUNT_LEVEL->value,
            ]
        )
        ->assertJsonValidationErrorFor('discount_level_id')
        ->assertStatus(422);
    }
}
