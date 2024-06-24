<?php

namespace Tests\Feature\App\Api\Admin\Accounts\Controllers;

use App\Api\Admin\Accounts\Requests\AccountMembershipRequest;
use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AccountMembershipControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_list_account_membership()
    {
        $account = Account::factory()->create();
        Subscription::factory(5)->create(['account_id' => $account->id]);
        $this->getJson(route('admin.account-membership.index', ['account_id' => $account->id]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'start_date',
                        'end_date',
                        'subscription_price',
                        'amount_paid',
                        'order_id',
                        'cancelled',
                        'product'
                    ]
                ]
            )
            ->assertJsonCount(5);
    }

    /** @test */
    public function can_get_active_account_membership()
    {
        $account = Account::factory()->create();
        $start_date = Carbon::now()->subMonths(3)->format('Y-m-d H:i:s');
        Subscription::factory()->create(['account_id' => $account->id, 'start_date' => $start_date]);
        Subscription::factory(5)->create(['account_id' => $account->id, 'cancelled' => Carbon::now()->format('Y-m-d H:i:s')]);
        $activeMemberShip = $this->getJson(route('admin.account-membership.show', [$account]))
            ->assertOk();
        $formattedDate = Carbon::parse($activeMemberShip['start_date'])->format('Y-m-d H:i:s');
        $this->assertEquals($start_date, $formattedDate);
        $this->assertNull($activeMemberShip['cancelled']);
    }

    /** @test */
    public function can_cancel_active_account_membership()
    {
        $subscription = Subscription::factory()->create();
        $this->deleteJson(route('admin.account-membership.destroy', [$subscription]))
            ->assertOk();
        $this->assertNotNull($subscription->refresh()->cancelled);
        $this->assertEquals(0, $subscription->refresh()->status);
    }


    /** @test */
    public function can_create_account_membership()
    {
        AccountMembershipRequest::fake();

        $this->postJson(route('admin.account-membership.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Subscription::Table(), 1);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        AccountMembershipRequest::fake(['start_date' => '']);

        $this->postJson(route('admin.account-membership.store'))
            ->assertJsonValidationErrorFor('start_date')
            ->assertStatus(422);
    }
}
