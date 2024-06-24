<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductByZoomTemplateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_product_zoom_template()
    {
        $products = Product::factory(10)->create();
        $displayTemplate = DisplayTemplate::factory()->create();
        ProductSiteSettings::factory()->create(['product_zoom_template'=>$displayTemplate->id,'product_id'=>$products[0]->id]);
        ProductSiteSettings::factory()->create(['product_zoom_template'=>$displayTemplate->id,'product_id'=>$products[1]->id]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::PRODUCT_ZOOM_TEMPLATE_IS->value,
                'template_id' => $displayTemplate->id,
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
                'search_option' => SearchOptions::PRODUCT_ZOOM_TEMPLATE_IS->value,
            ]
        )
        ->assertJsonValidationErrorFor('template_id')
        ->assertStatus(422);
    }
}
