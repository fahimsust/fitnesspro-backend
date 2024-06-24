<?php

namespace Tests\Feature\App\Api\Admin\Referrals\Controllers;

use Domain\Affiliates\Actions\ChangeReferralStatus;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ReferralControllerTest extends ControllerTestCase
{
    public Referral $referral;
    protected function setUp(): void
    {
        parent::setUp();
        $this->referral = Referral::factory()->create();
        $this->createAndAuthAdminUser();
    }

    public function can_get_all_the_referrals()
    {
        Referral::factory(3)->create();

        $this->getJson(route('admin.referral.index'))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(3,'data');
    }

    /** @test */
    public function can_get_all_the_referral_by_keyword()
    {
        $order1 = Order::factory()->create(['order_no'=>'123456-01']);
        $order2 = Order::factory()->create(['order_no'=>'123456-02']);
        $order3 = Order::factory()->create(['order_no'=>'456789-01']);
        Referral::factory()->create(['order_id'=>$order1->id]);
        Referral::factory()->create(['order_id'=>$order2->id]);
        Referral::factory()->create(['order_id'=>$order3->id]);
        $this->getJson(route('admin.referral.index',['keyword'=>'123456']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(2,'data');
    }
    /** @test */
    public function can_get_all_the_referral_by_status()
    {
        $status = ReferralStatus::factory(5)->create();
        Referral::factory()->create(['status_id'=>$status[0]->id]);
        Referral::factory()->create(['status_id'=>$status[0]->id]);
        Referral::factory()->create(['status_id'=>$status[1]->id]);
        $this->getJson(route('admin.referral.index',['status_id'=>$status[0]->id]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(2,'data');
    }
    /** @test */
    public function can_get_all_the_referral_by_affiliate_name()
    {
        $affiliate = Affiliate::factory()->create(['name'=>'test01']);
        Referral::factory(5)->create(['affiliate_id'=>$affiliate->id]);
        $this->getJson(route('admin.referral.index',['name'=>'test']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(5,'data');
    }
    /** @test */
    public function can_get_all_the_referral_by_status_and_keyword()
    {
        $status = ReferralStatus::factory(5)->create();
        $order1 = Order::factory()->create(['order_no'=>'123456-01']);
        $order2 = Order::factory()->create(['order_no'=>'123456-02']);
        $order3 = Order::factory()->create(['order_no'=>'456789-01']);
        Referral::factory()->create(['status_id'=>$status[0]->id,'order_id'=>$order1->id]);
        Referral::factory()->create(['status_id'=>$status[0]->id,'order_id'=>$order3->id]);
        Referral::factory()->create(['status_id'=>$status[1]->id,'order_id'=>$order2->id]);

        $this->getJson(route('admin.referral.index',['status_id'=>$status[0]->id,'keyword'=>'123456']))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'amount',
                    'order',
                    'status',
                    'type_label'
                ]
            ]])->assertJsonCount(1,'data');
    }

    /** @test */
    public function can_change_referral_status()
    {
        $status = ReferralStatus::factory()->create();
        $this->putJson(route('admin.referral.update', [$this->referral]), ['status_id' => $status->id])
            ->assertCreated()
            ->assertJsonStructure(['status_id']);

        $this->assertEquals($status->id,$this->referral->refresh()->status_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->putJson(route('admin.referral.update', [$this->referral]), ['status_id' => 0])
            ->assertJsonValidationErrorFor('status_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(ChangeReferralStatus::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $status = ReferralStatus::factory()->create();
        $this->putJson(route('admin.referral.update', [$this->referral]), ['status_id' => $status->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals($status->id,$this->referral->refresh()->status_id);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $status = ReferralStatus::factory()->create();
        $this->putJson(route('admin.referral.update', [$this->referral]), ['status_id' => $status->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals($status->id,$this->referral->refresh()->status_id);
    }
}
