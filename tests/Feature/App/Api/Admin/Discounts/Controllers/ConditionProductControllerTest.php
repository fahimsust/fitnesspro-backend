<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionProductControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_product()
    {
        $product = Product::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-product.store'),
        [
            'product_id'=>$product->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionProduct::Table(), 1);
    }

    /** @test */
    public function can_update_discount_condition_product()
    {
        $conditionProduct = ConditionProduct::factory()->create();
        $request = [
            'required_qty'=>10,
        ];

        $this->putJson(route('admin.condition-product.update', [$conditionProduct]),$request)
            ->assertCreated();

        $this->assertDatabaseHas(ConditionProduct::Table(),$request);
    }

    /** @test */
    public function can_delete_discount_condition_product()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionProduct = [];
        foreach($discountConditions as $discountCondition)
            $conditionProduct[] = ConditionProduct::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-product.destroy', [$conditionProduct[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionProduct::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $product = Product::factory()->create();
        $this->postJson(route('admin.condition-product.store'),
        [
            'product_id'=>$product->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionProduct::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $product = Product::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-product.store'),
        [
            'product_id'=>$product->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionProduct::Table(), 0);
    }
}
