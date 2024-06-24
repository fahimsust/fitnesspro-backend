<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformSetZoomTemplateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_zoom_template()
    {
        $displayTemplates = DisplayTemplate::factory(2)->create();
        $products = Product::factory(10)->create();
        foreach($products as $product)
        {
            ProductSettings::factory()->create(['product_id'=>$product->id,'product_zoom_template'=>$displayTemplates[0]->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_ZOOM_TEMPLATE,
                'template_id' => $displayTemplates[1]->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($displayTemplates[1]->id, ProductSettings::first()->product_zoom_template);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_ZOOM_TEMPLATE,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('template_id')
        ->assertStatus(422);
    }
}
