<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderReferralControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_order_referrals()
    {
        $order = Order::factory()->create();
        Referral::factory(9)->create(['order_id' => $order->id]);
        $this->getJson(route('admin.order.affiliate.index', [$order]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'amount',
                    'affiliate',
                ]
            ]])
            ->assertJsonCount(9, 'data');
    }
    /** @test */
    public function can_create_referral()
    {
        $order = Order::factory()->create();
        $affiliate = Affiliate::factory()->create();
        ReferralStatus::factory()->create(['id' => 1]);
        $this->postJson(route('admin.order.affiliate.store', $order), ['affiliate_id' => $affiliate->id])
            ->assertCreated()
            ->assertJsonStructure(['amount']);

        $this->assertDatabaseCount(Referral::Table(), 1);
    }
}
