<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductNotPublishedOnSiteTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_product_is_published_in_site()
    {
        $site = Site::factory()->create();
        $products = Product::factory(10)->create(['status'=>1]);
        $products2 = Product::factory(5)->create(['status'=>0]);
        foreach($products as $key=>$value)
        {
            $status = 1;
            if($key < 5)
            {
                $status = 0;
            }
            ProductPricing::factory()->create(
                [
                    'product_id'=>$value->id,
                    'site_id'=>$site->id,
                    'status'=>$status
                ]
            );
        }
        foreach($products2 as $key=>$value)
        {
            ProductPricing::factory()->create(
                [
                    'product_id'=>$value->id,
                    'site_id'=>$site->id,
                    'status'=>1
                ]
            );
        }

        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::NOT_PUBLISHED_ON_SITE->value,
                'site_id'=>$site->id
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
                'search_option' => SearchOptions::NOT_PUBLISHED_ON_SITE->value,
            ]
        )
        ->assertJsonValidationErrorFor('site_id')
        ->assertStatus(422);
    }
}
