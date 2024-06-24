<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Orders\Enums\Order\OrderStatuses;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestOrders;
use function route;

class OrderStatusControllerTest extends ControllerTestCase
{
    use TestOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_order_list()
    {
        $this->getJson(route('admin.order-status.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(count(OrderStatuses::cases()));
    }
}
