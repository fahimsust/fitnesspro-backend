<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionDistributor;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Distributors\Models\Distributor;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionDistributorControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_site()
    {
        $distributor = Distributor::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-distributor.store'),
        [
            'distributor_id'=>$distributor->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionDistributor::Table(), 1);
    }

    /** @test */
    public function can_delete_discount_condition_site()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionDistributor = [];
        foreach($discountConditions as $discountCondition)
            $conditionDistributor[] = ConditionDistributor::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-distributor.destroy', [$conditionDistributor[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionDistributor::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $distributor = Distributor::factory()->create();
        $this->postJson(route('admin.condition-distributor.store'),
        [
            'distributor_id'=>$distributor->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionDistributor::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $distributor = Distributor::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-distributor.store'),
        [
            'distributor_id'=>$distributor->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionDistributor::Table(), 0);
    }
}
