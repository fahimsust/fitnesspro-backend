<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformPublishedOnSiteTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_published_on_site()
    {
        $products = Product::factory(10)->create();
        $site = Site::factory()->create();
        foreach($products as $product)
        {
            ProductPricing::factory()->create(['product_id'=>$product->id,'status'=>0,'site_id'=>$site->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::PUBLISH_ON_SITE,
                'site_id' => $site->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals(1, ProductPricing::first()->status);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::PUBLISH_ON_SITE,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('site_id')
        ->assertStatus(422);
    }
}
