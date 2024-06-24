<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderItemNoteControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_note_order_item()
    {
        $orderItem = OrderItem::factory()->create();
        $this->postJson(route('admin.order-item.note', $orderItem), ['note' => 'test'])
            ->assertCreated();

        $this->assertEquals('test', $orderItem->refresh()->product_notes);
    }
}
