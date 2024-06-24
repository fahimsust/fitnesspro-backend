<?php

namespace Tests\Feature\Domain\Discounts\Actions;

use App\Firebase\User;
use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Discounts\Actions\CheckDiscountCondition;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\Cart;
use Domain\Sites\Models\Site;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

class CheckDiscountConditionTest extends TestCase
{
    use HasTestAccount;

    public Account $account;

    public Cart $cart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create();
        $this->createLoginAccount();
        $this->cart = Cart::firstOrFactory();
    }

    /** @test */
    public function check_account_login_required()
    {
        $condition = DiscountCondition::factory()
            ->create(['condition_type_id' => DiscountConditionTypes::REQUIRED_ACCOUNT]);

        $action = new CheckDiscountCondition(
            new DiscountCheckerData(),
            $condition,
            $this->cart
        );

        $this->assertTrue($action->execute());
    }

    /** @test */
    public function check_account_required_account_type()
    {
        $condition = DiscountCondition::factory()->create(['condition_type_id' => DiscountConditionTypes::REQUIRED_ACCOUNT_TYPE]);
        ConditionAccountType::factory()->create();

        $action = new CheckDiscountCondition(
            new DiscountCheckerData(),
            $condition,
            $this->cart,
            $this->account
        );

        $this->assertTrue($action->execute());
    }

    /** @test */
    public function check_account_membership_level()
    {
        $condition = DiscountCondition::factory()
            ->create(['condition_type_id' => DiscountConditionTypes::ACTIVE_MEMBERSHIP_LEVEL]);
        ConditionMembershipLevel::factory()->create();
        Subscription::factory()
            ->for($this->account, 'subscriber')
            ->create();

        $action = new CheckDiscountCondition(
            new DiscountCheckerData(),
            $condition,
            $this->cart,
            $this->account
        );

        $this->assertTrue($action->execute());
    }

    /** @test */
    public function check_membership_expire_days()
    {
        $condition = DiscountCondition::factory()->create(['required_code' => 10, 'condition_type_id' => DiscountConditionTypes::MEMBERSHIP_EXPIRES_IN_DAYS]);
        ConditionMembershipLevel::factory()->create();
        Subscription::factory()
            ->for($this->account, 'subscriber')
            ->create([
                'end_date' => Carbon::now()->addDay(10)->toDateTimeString()
            ]);

        $this->assertTrue(
            CheckDiscountCondition::now(
                new DiscountCheckerData(),
                $condition,
                $this->cart,
                $this->account
            )
        );
    }

    /** @test */
    public function check_site_match()
    {
        $condition = DiscountCondition::factory()->create(['required_code' => 10, 'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE]);
        ConditionSite::factory()->create(['site_id' => $this->cart->site_id]);

        $this->assertTrue(
            (new CheckDiscountCondition(
                new DiscountCheckerData(),
                $condition,
                $this->cart,
                $this->account
            ))
                ->execute()
        );
    }
}
