<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionProductType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionProductTypeControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_product_type()
    {
        $productType = ProductType::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-product-type.store'),
        [
            'producttype_id'=>$productType->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionProductType::Table(), 1);
    }

    /** @test */
    public function can_update_discount_condition_product_type()
    {
        $conditionProduct = ConditionProductType::factory()->create();
        $request = [
            'required_qty'=>10,
        ];

        $this->putJson(route('admin.condition-product-type.update', [$conditionProduct]),$request)
            ->assertCreated();

        $this->assertDatabaseHas(ConditionProductType::Table(),$request);
    }

    /** @test */
    public function can_delete_discount_condition_product_type()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionProduct = [];
        foreach($discountConditions as $discountCondition)
            $conditionProduct[] = ConditionProductType::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-product-type.destroy', [$conditionProduct[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionProductType::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $productType = ProductType::factory()->create();
        $this->postJson(route('admin.condition-product-type.store'),
        [
            'producttype_id'=>$productType->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionProductType::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $productType = ProductType::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-product-type.store'),
        [
            'producttype_id'=>$productType->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionProductType::Table(), 0);
    }
}
