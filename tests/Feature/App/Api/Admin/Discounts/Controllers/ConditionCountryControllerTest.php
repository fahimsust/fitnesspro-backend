<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionCountry;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Locales\Models\Country;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionCountryControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_site()
    {
        $country = Country::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-country.store'),
        [
            'country_id'=>$country->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionCountry::Table(), 1);
    }

    /** @test */
    public function can_delete_discount_condition_site()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionCountry = [];
        foreach($discountConditions as $discountCondition)
            $conditionCountry[] = ConditionCountry::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-country.destroy', [$conditionCountry[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionCountry::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $country = Country::factory()->create();
        $this->postJson(route('admin.condition-country.store'),
        [
            'country_id'=>$country->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionCountry::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $country = Country::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-country.store'),
        [
            'country_id'=>$country->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionCountry::Table(), 0);
    }
}
