<?php

namespace Tests\Feature\App\Api\Admin\AccountType\Controllers;

use App\Api\Admin\AccountType\Requests\AccountTypeRequest;
use Domain\Accounts\Models\AccountType;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingConditionItem;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AccountTypesControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_account_type()
    {
        AccountType::factory(30)->create();

        $response = $this->getJson(route('admin.account-types.list', ["per_page" => 5, "page" => 2]))
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
        AccountType::factory()->create(['name' => 'test1']);
        AccountType::factory()->create(['name' => 'test2']);
        AccountType::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.account-types.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
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
        $accountTypes = AccountType::factory(10)->create();
        OrderingConditionItem::factory()->create(['item_id' => $accountTypes[0]->id,'condition_id'=>$orderingCondition->id]);
        OrderingConditionItem::factory()->create(['item_id' => $accountTypes[1]->id,'condition_id'=>$orderingCondition->id]);
        OrderingConditionItem::factory()->create(['item_id' => $accountTypes[2]->id,'condition_id'=>$orderingCondition->id]);
        $this->getJson(
            route('admin.account-types.list', ['condition_id' => $orderingCondition->id]),
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
    public function can_create_new_account_type()
    {
        AccountTypeRequest::fake();

        $response = $this->postJson(route('admin.account-type.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(AccountType::Table(), 1);
    }

    /** @test */
    public function can_update_account_type()
    {
        $accountType = AccountType::factory()->create();
        AccountTypeRequest::fake(['name' => 'test']);

        $response = $this->putJson(route('admin.account-type.update', [$accountType]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test',$accountType->refresh()->name);
    }

    /** @test */
    public function can_search_account_type_for_discount_condition_id()
    {
        $discountCondition = DiscountCondition::factory()->create();
        $accountTypes = AccountType::factory(10)->create();
        ConditionAccountType::factory()->create(['accounttype_id' => $accountTypes[0]->id,'condition_id'=>$discountCondition->id]);
        ConditionAccountType::factory()->create(['accounttype_id' => $accountTypes[1]->id,'condition_id'=>$discountCondition->id]);
        ConditionAccountType::factory()->create(['accounttype_id' => $accountTypes[2]->id,'condition_id'=>$discountCondition->id]);
        $this->getJson(
            route('admin.account-types.list', ['discount_condition_id' => $discountCondition->id]),
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
            route('admin.account-types.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
        ->assertStatus(401)
        ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
