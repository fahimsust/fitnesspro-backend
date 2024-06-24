<?php

namespace Tests\Feature\App\Api\Admin\Speciality\Controllers;

use Domain\Accounts\Models\Specialty;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingConditionItem;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SpecialitiesControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_account_type()
    {
        Specialty::factory(30)->create();

        $response = $this->getJson(route('admin.specialities.list', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(2, $response['current_page']);
    }

    /** @test */
    public function can_search_account_type()
    {
        Specialty::factory()->create(['name' => 'test1']);
        Specialty::factory()->create(['name' => 'test2']);
        Specialty::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.specialities.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(2, 'data');
    }
    /** @test */
    public function can_search_account_type_for_condition_id()
    {
        $orderingCondition = OrderingCondition::factory()->create();
        $specialties = Specialty::factory(10)->create();
        OrderingConditionItem::factory()->create(['item_id' => $specialties[0]->id,'condition_id'=>$orderingCondition->id]);
        OrderingConditionItem::factory()->create(['item_id' => $specialties[1]->id,'condition_id'=>$orderingCondition->id]);
        OrderingConditionItem::factory()->create(['item_id' => $specialties[2]->id,'condition_id'=>$orderingCondition->id]);
        $this->getJson(
            route('admin.specialities.list', ['condition_id' => $orderingCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(7, 'data');
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->getJson(
            route('admin.specialities.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
        ->assertStatus(401)
        ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
