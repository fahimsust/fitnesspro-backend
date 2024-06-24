<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Order\Order;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AccountOrderControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_account_orders()
    {
        $account = Account::factory()->create();
        Order::factory(5)->create(['account_id' => $account->id]);
        $this->getJson(route('admin.account-order.index', ['account_id' => $account->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'order_no',
                    'created_at'
                ]
            ])
            ->assertJsonCount(5);
    }
}
