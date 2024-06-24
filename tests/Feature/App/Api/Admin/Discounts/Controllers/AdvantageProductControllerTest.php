<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AdvantageProductControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_advantage_product()
    {
        $product = Product::factory()->create();
        $discountAdvantage = DiscountAdvantage::factory()->create();

        $this->postJson(route('admin.advantage-product.store'),
        [
            'product_id'=>$product->id,
            'advantage_id'=>$discountAdvantage->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(AdvantageProduct::Table(), 1);
    }

    /** @test */
    public function can_update_discount_advantage_product()
    {
        $advantageProduct = AdvantageProduct::factory()->create();
        $request = [
            'applyto_qty'=>10,
        ];

        $this->putJson(route('admin.advantage-product.update', [$advantageProduct]),$request)
            ->assertCreated();

        $this->assertDatabaseHas(AdvantageProduct::Table(),$request);
    }

    /** @test */
    public function can_delete_discount_advantage_product()
    {
        $advantageProduct = AdvantageProduct::factory(5)->create();

        $this->deleteJson(route('admin.advantage-product.destroy', [$advantageProduct->first()]))
            ->assertOk();

        $this->assertDatabaseCount(AdvantageProduct::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $product = Product::factory()->create();
        $this->postJson(route('admin.advantage-product.store'),
        [
            'product_id'=>$product->id,
        ])
            ->assertJsonValidationErrorFor('advantage_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(AdvantageProduct::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $product = Product::factory()->create();
        $discountAdvantage = DiscountAdvantage::factory()->create();

        $this->postJson(route('admin.advantage-product.store'),
        [
            'product_id'=>$product->id,
            'advantage_id'=>$discountAdvantage->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AdvantageProduct::Table(), 0);
    }
}
