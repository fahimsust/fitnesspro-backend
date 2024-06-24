<?php

namespace Tests\Unit\Domain\Accounts\Actions\Membership;

use App\Api\Accounts\Requests\Membership\NewMemberRequest;
use Database\Seeders\AffiliateSeeder;
use Database\Seeders\SiteSeeder;
use Domain\Accounts\Actions\Membership\CreateMembership;
use Domain\Accounts\DataTransferObjects\RegisteringMemberData;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Affiliates\Actions\GetSubscriptionReferralPoints;
use Domain\Affiliates\Models\Referral;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use Tests\TestCase;

class CreateMembershipTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            //     CountrySeeder::class,
            //     CountryRegionSeeder::class,
            //     StateSeeder::class,
            //     AccountStatusSeeder::class,
            //    AccountTypeSeeder::class,
            //     SiteSeeder::class,
            AffiliateSeeder::class,
            SiteSeeder::class,
        ]);
    }

    /** @test */
    public function create_membership_with_referral()
    {
        ReferralStatus::factory()->create(['id' => 1]);
        $this->withExceptionHandling();
        $amountPaid = 50000.04;

        $request_data = NewMemberRequest::factory()
            ->withMembershipAndAffiliate($amountPaid)
            ->create();

        $memberRequest = new NewMemberRequest();
        $memberRequest->setMethod('POST');
        $memberRequest->request->add($request_data);

        $memberData = RegisteringMemberData::fromRequest($memberRequest);
        $memberData->order_id = Order::factory()->create()->id;

        $account = Account::create(
            $memberData->accountArray()
        );

        $creator = CreateMembership::run($account, $memberData->subscriptionArray());

        $subscription = $creator->subscription;
        $referral = $creator->referral;

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals(1, Subscription::count());

        $this->assertEquals($amountPaid, $subscription->amount_paid);
        $this->assertInstanceOf(Referral::class, $referral);
        $this->assertEquals(
            $referral->amount,
            GetSubscriptionReferralPoints::now(
                $account->affiliate->loadMissingReturn('level'),
                $subscription->level
            )
        );

        $this->assertEquals(1, Referral::count());
    }
}
