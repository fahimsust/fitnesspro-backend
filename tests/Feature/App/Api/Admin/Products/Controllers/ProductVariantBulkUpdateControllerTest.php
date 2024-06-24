<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Content\Models\Image;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\ProductAvailability;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestProductVariantInventory;
use function route;

class ProductVariantBulkUpdateControllerTest extends ControllerTestCase
{
    use TestProductVariantInventory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->createProductVariantInventory();
    }

    /** @test */
    public function get_update_product_status()
    {

        $this->postJson(
            route('admin.variant-bulk-update.status'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'status' => -1
            ]
        )
            ->assertOk();
        $this->assertEquals(-1,$this->products[0]->refresh()->status);
        $this->assertEquals(-1,$this->products[1]->refresh()->status);
    }
    /** @test */
    public function can_validate_request_and_return_errors_for_status()
    {
        $this->postJson(
            route('admin.variant-bulk-update.status'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'status' => 'test'
            ]
        )
            ->assertJsonValidationErrorFor('status')
            ->assertStatus(422);
    }

    /** @test */
    public function get_update_product_out_of_stock()
    {
        $productAvailability = ProductAvailability::factory()->create();
        $this->postJson(
            route('admin.variant-bulk-update.out-of-stock'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'default_outofstockstatus_id' => $productAvailability->id
            ]
        )
            ->assertOk();
        $this->assertEquals($productAvailability->id,$this->products[0]->refresh()->default_outofstockstatus_id);
        $this->assertEquals($productAvailability->id,$this->products[1]->refresh()->default_outofstockstatus_id);
    }
    /** @test */
    public function can_validate_request_and_return_errors_for_out_of_stock()
    {
        $this->postJson(
            route('admin.variant-bulk-update.out-of-stock'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'default_outofstockstatus_id' => 'test'
            ]
        )
            ->assertJsonValidationErrorFor('default_outofstockstatus_id')
            ->assertStatus(422);
    }

    /** @test */
    public function get_update_product_default_distributor()
    {
        $distributor = Distributor::factory()->create();
        $this->postJson(
            route('admin.variant-bulk-update.default-distributor'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'default_distributor_id' => $distributor->id
            ]
        )
            ->assertOk();
        $this->assertEquals($distributor->id,$this->products[0]->refresh()->default_distributor_id);
        $this->assertEquals($distributor->id,$this->products[1]->refresh()->default_distributor_id);
    }
    /** @test */
    public function can_validate_request_and_return_errors_for_default_distributor()
    {
        $this->postJson(
            route('admin.variant-bulk-update.default-distributor'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'default_distributor_id' => 'test'
            ]
        )
            ->assertJsonValidationErrorFor('default_distributor_id')
            ->assertStatus(422);
    }

    /** @test */
    public function get_update_product_image()
    {
        $image = Image::factory()->create();
        $this->postJson(
            route('admin.variant-bulk-update.image'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'details_img_id' => $image->id
            ]
        )
            ->assertOk();
        $this->assertEquals($image->id,$this->products[0]->refresh()->details_img_id);
        $this->assertEquals($image->id,$this->products[1]->refresh()->details_img_id);
    }
    /** @test */
    public function can_validate_request_and_return_errors_for_image()
    {
        $this->postJson(
            route('admin.variant-bulk-update.image'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'details_img_id' => 'test'
            ]
        )
            ->assertJsonValidationErrorFor('details_img_id')
            ->assertStatus(422);
    }

    /** @test */
    public function get_update_product_distributor_stock_quantity()
    {
        $this->postJson(
            route('admin.variant-bulk-update.distributor-stock-quantity'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'distributor_id' => $this->distributors[0]->id,
                'stock_qty'=>4
            ]
        )
            ->assertOk();
        $this->assertEquals(6,$this->products[0]->refresh()->combined_stock_qty);
        $this->assertEquals(6,$this->products[1]->refresh()->combined_stock_qty);
        $this->assertEquals(24,$this->product->refresh()->combined_stock_qty);
    }
    /** @test */
    public function can_validate_request_and_return_errors_for_distributor_stock_quantity()
    {
        $this->postJson(
            route('admin.variant-bulk-update.distributor-stock-quantity'),
            [
                'products' => [$this->products[0]->id, $this->products[1]->id],
                'stock_qty'=>4
            ]
        )
            ->assertJsonValidationErrorFor('distributor_id')
            ->assertStatus(422);
    }

}
