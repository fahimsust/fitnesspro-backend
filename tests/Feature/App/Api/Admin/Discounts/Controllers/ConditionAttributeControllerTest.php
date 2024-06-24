<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionAttributeControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_attribute()
    {
        $attributeOption = AttributeOption::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-attribute.store'),
        [
            'attributevalue_id'=>$attributeOption->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionAttribute::Table(), 1);
    }

    /** @test */
    public function can_update_discount_condition_attribute()
    {
        $conditionAttribute = ConditionAttribute::factory()->create();
        $request = [
            'required_qty'=>10,
        ];

        $this->putJson(route('admin.condition-attribute.update', [$conditionAttribute]),$request)
            ->assertCreated();

        $this->assertDatabaseHas(ConditionAttribute::Table(),$request);
    }

    /** @test */
    public function can_delete_discount_condition_attribute()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionAttribute = [];
        foreach($discountConditions as $discountCondition)
            $conditionAttribute[] = ConditionAttribute::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-attribute.destroy', [$conditionAttribute[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionAttribute::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $attributeOption = AttributeOption::factory()->create();;
        $this->postJson(route('admin.condition-attribute.store'),
        [
            'attributevalue_id'=>$attributeOption->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionAttribute::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $attributeOption = AttributeOption::factory()->create();;
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-attribute.store'),
        [
            'attributevalue_id'=>$attributeOption->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionAttribute::Table(), 0);
    }
}
