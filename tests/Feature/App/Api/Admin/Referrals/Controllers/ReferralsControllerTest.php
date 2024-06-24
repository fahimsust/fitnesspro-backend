<?php

namespace Tests\Feature\App\Api\Admin\Referrals\Controllers;

use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ReferralsControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_all_the_referral_by_affiliate()
    {
        $affiliate = Affiliate::factory()->create();
        Referral::factory(3)->create();
        $this->getJson(route('admin.referrals.list', ['affiliate_id' => $affiliate->id]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(3, 'data');
    }

    /** @test */
    public function can_get_all_the_referral_by_keyword()
    {
        $affiliate = Affiliate::factory()->create();
        $order1 = Order::factory()->create(['order_no' => '123456-01']);
        $order2 = Order::factory()->create(['order_no' => '123456-02']);
        $order3 = Order::factory()->create(['order_no' => '456789-01']);
        Referral::factory()->create(['order_id' => $order1->id]);
        Referral::factory()->create(['order_id' => $order2->id]);
        Referral::factory()->create(['order_id' => $order3->id]);
        $this->getJson(route('admin.referrals.list', ['affiliate_id' => $affiliate->id,'keyword' => '123456']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_get_all_the_referral_by_status()
    {
        $affiliate = Affiliate::factory()->create();
        $status = ReferralStatus::factory(5)->create();
        Referral::factory()->create(['status_id' => $status[0]->id]);
        Referral::factory()->create(['status_id' => $status[0]->id]);
        Referral::factory()->create(['status_id' => $status[1]->id]);
        $this->getJson(route('admin.referrals.list', ['affiliate_id' => $affiliate->id,'status_id' => $status[0]->id]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_get_all_the_referral_by_status_and_keyword()
    {
        $affiliate = Affiliate::factory()->create();
        $status = ReferralStatus::factory(5)->create();
        $order1 = Order::factory()->create(['order_no' => '123456-01']);
        $order2 = Order::factory()->create(['order_no' => '123456-02']);
        $order3 = Order::factory()->create(['order_no' => '456789-01']);
        Referral::factory()->create(['status_id' => $status[0]->id, 'order_id' => $order1->id]);
        Referral::factory()->create(['status_id' => $status[0]->id, 'order_id' => $order3->id]);
        Referral::factory()->create(['status_id' => $status[1]->id, 'order_id' => $order2->id]);

        $this->getJson(route('admin.referrals.list', ['affiliate_id' => $affiliate->id,'status_id' => $status[0]->id, 'keyword' => '123456']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(1, 'data');
    }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $affiliate = Affiliate::factory()->create();
        Referral::factory(5)->create();

        $this->getJson(route('admin.referrals.list', ['affiliate_id' => $affiliate->id,'status_id' => 0]),)
            ->assertJsonValidationErrorFor('status_id')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $affiliate = Affiliate::factory()->create();
        Referral::factory(3)->create();
        $this->getJson(route('admin.referrals.list', ['affiliate_id' => $affiliate->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
