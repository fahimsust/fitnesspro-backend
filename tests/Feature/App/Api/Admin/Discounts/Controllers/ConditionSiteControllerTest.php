<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionSiteControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_site()
    {
        $site = Site::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-site.store'),
        [
            'site_id'=>$site->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionSite::Table(), 1);
    }

    /** @test */
    public function can_delete_discount_condition_site()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionSite = [];
        foreach($discountConditions as $discountCondition)
            $conditionSite[] = ConditionSite::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-site.destroy', [$conditionSite[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionSite::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $site = Site::factory()->create();
        $this->postJson(route('admin.condition-site.store'),
        [
            'site_id'=>$site->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionSite::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $site = Site::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-site.store'),
        [
            'site_id'=>$site->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionSite::Table(), 0);
    }
}
