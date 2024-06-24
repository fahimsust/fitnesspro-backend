<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductByNotThumbnailTemplateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_product_not_thumbnail_template()
    {
        $products = Product::factory(10)->create();
        $displayTemplate = DisplayTemplate::factory()->create();
        ProductSiteSettings::factory()->create(['product_thumbnail_template'=>$displayTemplate->id,'product_id'=>$products[0]->id]);
        ProductSiteSettings::factory()->create(['product_thumbnail_template'=>$displayTemplate->id,'product_id'=>$products[1]->id]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::PRODUCT_THUMBNAIL_TEMPLATE_IS_NOT->value,
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
            ->assertJsonCount(8);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::PRODUCT_THUMBNAIL_TEMPLATE_IS_NOT->value,
            ]
        )
        ->assertJsonValidationErrorFor('template_id')
        ->assertStatus(422);
    }
}
