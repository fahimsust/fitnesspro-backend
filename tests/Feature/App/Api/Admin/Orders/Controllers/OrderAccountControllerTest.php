<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class OrderAccountControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->createOrders();
    }

    /** @test */
    public function can_assign_customer()
    {
        $order = Order::factory()->create();
        $account = Account::factory()->create();

        $this->putJson(route('admin.order.account.update', [$order, $account]))
            ->assertCreated();

        $this->assertEquals($account->id, $order->refresh()->account_id);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function can_delete_customer()
    {
        $account = Account::factory()->create();
        $order = Order::factory()->create(['account_id' => $account->id]);

        $this->deleteJson(route('admin.order.account.update', [$order, $account]))
            ->assertOk();

        $this->assertNull($order->refresh()->account_id);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }
}
