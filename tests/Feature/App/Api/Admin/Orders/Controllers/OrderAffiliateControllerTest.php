<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Affiliates\Models\Affiliate;
use Domain\Orders\Models\Order\Order;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderAffiliateControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_order_referrals()
    {
        $affiliate = Affiliate::factory()->create();
        $order = Order::factory()->create(['affiliate_id'=>$affiliate->id]);
        $this->postJson(route('admin.order.remove-affiliate', [$order->id]))
            ->assertOk();
        $this->assertNull($order->refresh()->affiliate_id);
    }
}
