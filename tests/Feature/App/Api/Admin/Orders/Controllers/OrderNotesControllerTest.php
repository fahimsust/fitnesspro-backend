<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderNote;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderNotesControllerTest extends ControllerTestCase
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
        OrderNote::factory(9)->create();
        $this->getJson(route('admin.order.note.index', [$order]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'note',
                    'created',
                ]
            ]])
            ->assertJsonCount(9, 'data');
    }
    /** @test */
    public function can_create_note_order()
    {
        $order = Order::factory()->create();
        $this->postJson(route('admin.order.note.store', $order), ['note' => 'test'])
            ->assertCreated()
            ->assertJsonStructure(['note']);

        $this->assertDatabaseCount(OrderNote::Table(), 1);
    }
}
