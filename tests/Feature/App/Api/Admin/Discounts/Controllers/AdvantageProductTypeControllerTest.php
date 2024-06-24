<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AdvantageProductTypeControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_advantage_product()
    {
        $productType = ProductType::factory()->create();
        $discountAdvantage = DiscountAdvantage::factory()->create();

        $this->postJson(route('admin.advantage-product-type.store'),
        [
            'producttype_id'=>$productType->id,
            'advantage_id'=>$discountAdvantage->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(AdvantageProductType::Table(), 1);
    }

    /** @test */
    public function can_update_discount_advantage_product_type()
    {
        $advantageProductType = AdvantageProductType::factory()->create();
        $request = [
            'applyto_qty'=>10,
        ];

        $this->putJson(route('admin.advantage-product-type.update', [$advantageProductType]),$request)
            ->assertCreated();

        $this->assertDatabaseHas(AdvantageProductType::Table(),$request);
    }

    /** @test */
    public function can_delete_discount_advantage_product_type()
    {
        $productTypes = AdvantageProductType::factory(5)->create();

        $this->deleteJson(route('admin.advantage-product-type.destroy', [$productTypes->first()]))
            ->assertOk();

        $this->assertDatabaseCount(AdvantageProductType::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $productType = ProductType::factory()->create();
        $this->postJson(route('admin.advantage-product-type.store'),
        [
            'producttype_id'=>$productType->id,
        ])
            ->assertJsonValidationErrorFor('advantage_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(AdvantageProductType::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $productType = ProductType::factory()->create();
        $discountAdvantage = DiscountAdvantage::factory()->create();

        $this->postJson(route('admin.advantage-product-type.store'),
        [
            'producttype_id'=>$productType->id,
            'advantage_id'=>$discountAdvantage->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AdvantageProductType::Table(), 0);
    }
}
