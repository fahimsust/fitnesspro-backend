<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Accounts\Models\AccountType;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionAccountTypeControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_site()
    {
        $accountType = AccountType::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-account-type.store'),
        [
            'accounttype_id'=>$accountType->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionAccountType::Table(), 1);
    }

    /** @test */
    public function can_delete_discount_condition_site()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionAccountType = [];
        foreach($discountConditions as $discountCondition)
            $conditionAccountType[] = ConditionAccountType::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-account-type.destroy', [$conditionAccountType[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionAccountType::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $accountType = AccountType::factory()->create();
        $this->postJson(route('admin.condition-account-type.store'),
        [
            'accounttype_id'=>$accountType->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionAccountType::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $accountType = AccountType::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-account-type.store'),
        [
            'accounttype_id'=>$accountType->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionAccountType::Table(), 0);
    }
}
