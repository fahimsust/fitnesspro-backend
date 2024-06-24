<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Orders\Models\Order\Order;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderEmailControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_email_sent()
    {
        $order = Order::factory()->create();
        AdminEmailsSent::factory(5)->create(['order_id' => $order->id]);
        $this->getJson(route('admin.order.email.index', [$order]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'subject',
                    'content',
                    'sent_date',
                    'sent_by',
                    'sent_to_account'
                ]
            ]])
            ->assertJsonCount(5,'data');
    }
}
