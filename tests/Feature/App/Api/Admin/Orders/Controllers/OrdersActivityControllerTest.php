<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrdersActivityControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_order_activity_list()
    {
        $order = Order::factory()->create();
        OrderActivity::factory(9)->create();
        $this->getJson(route('admin.order.activity.index', [$order]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'description',
                    'created',
                ]
            ]])
            ->assertJsonCount(9, 'data');
    }
}
