<?php

namespace Tests\Feature\App\Api\Admin\OrderingConditions\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Specialty;
use Domain\Products\Actions\OrderingRules\AddItemToOrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingConditionItem;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderingConditionItemControllerTest extends ControllerTestCase
{
    public OrderingCondition $orderingCondition;
    public Specialty $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->orderingCondition = OrderingCondition::factory()->create();
        $this->item = Specialty::factory()->create();
    }

    /** @test */
    public function can_add_item_to_ordering_condition()
    {
        $this->postJson(route('admin.ordering-condition.item.store', [$this->orderingCondition]),['item_id'=>$this->item->id])
            ->assertCreated()
            ->assertJsonStructure(['item_id', 'condition_id']);

        $this->assertDatabaseCount(OrderingConditionItem::Table(), 1);
    }

    /** @test */
    public function can_remove_item_from_ordering_condition()
    {
        OrderingConditionItem::factory()->create(['item_id'=>$this->item->id,'condition_id'=>$this->orderingCondition->id]);

        $this->deleteJson(
            route('admin.ordering-condition.item.destroy', [$this->orderingCondition,$this->item]),
        )->assertOk();

        $this->assertDatabaseCount(OrderingConditionItem::Table(), 0);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $accounts = Account::factory(11)->create();
        $this->postJson(route('admin.ordering-condition.item.store', [$this->orderingCondition]),['item_id'=>$accounts[10]->id])
            ->assertJsonValidationErrorFor('item_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(OrderingConditionItem::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AddItemToOrderingCondition::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

            $this->postJson(route('admin.ordering-condition.item.store', [$this->orderingCondition]),['item_id'=>$this->item->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(OrderingConditionItem::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.ordering-condition.item.store', [$this->orderingCondition]),['item_id'=>$this->item->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(OrderingConditionItem::Table(), 0);
    }
}
