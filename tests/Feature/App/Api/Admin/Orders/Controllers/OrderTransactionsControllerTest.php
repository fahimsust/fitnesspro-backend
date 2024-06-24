<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use App\Api\Admin\Orders\Requests\CreateOrderTransactionsRequest;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentMethod;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderTransactionsControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_order_note_list()
    {
        $order = Order::factory()->create();
        OrderTransaction::factory(9)->create();
        $this->getJson(route('admin.order.transaction.index', [$order]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'amount',
                    'created_at',
                    'transaction_no',
                    'cc_no',
                    'cc_exp',
                    'notes',
                ]
            ])
            ->assertJsonCount(9);
    }
    /** @test */
    public function can_create_note_order()
    {
        PaymentMethod::factory()->create(['id' => 2]);
        CreateOrderTransactionsRequest::fake();
        $order = Order::factory()->create();
        $this->postJson(route('admin.order.transaction.store', $order))
            ->assertCreated()
            ->assertJsonStructure([
                'amount',
                'transaction_no',
                'notes',
            ]);

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);
    }
}
