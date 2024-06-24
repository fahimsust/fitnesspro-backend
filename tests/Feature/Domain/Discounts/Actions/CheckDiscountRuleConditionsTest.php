<?php

namespace Tests\Feature\Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Discounts\Actions\CheckDiscountRuleConditions;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Exceptions\ConditionCheckFailed;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Carts\Cart;
use Domain\Sites\Models\Site;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CheckDiscountRuleConditionsTest extends TestCase
{
    public Account $account;
    public DiscountRule $rule;

    private Site $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create(['id' => config('site.id')]);

        $this->rule = DiscountRule::factory()->create();

        $this->createLoginAccount();
    }

    /** @todo */
    public function check_all_rule_match()
    {
        $this->bulkConditionsCreate();

        $this->assertTrue((new CheckDiscountRuleConditions(
            discountEntity: $this->rule,
            account: $this->account,
            cart: Cart::firstOrFactory()
        ))->handle());
    }

    /** @todo */
    public function check_all_rule_not_match()
    {
        ConditionSite::factory()
            ->for(DiscountCondition::factory()->create([
                'rule_id' => $this->rule->id,
                'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE
            ]))
            ->create([
                'site_id' => $this->site->id,
            ]);

        $this->withoutExceptionHandling();
        $this->expectExceptionCode(Response::HTTP_NOT_ACCEPTABLE);
        $this->expectException(ConditionCheckFailed::class);

        (new CheckDiscountRuleConditions(
            discountEntity: $this->rule,
            account: $this->account,
            cart: Cart::factory()->create([
                'site_id' => Site::factory()
            ])//setting wrong site so it fails
        ))->handle();
    }

    /** @todo */
    public function check_one_rule_not_match()
    {
        $this->rule->update(['match_anyall' => 1]);

        ConditionSite::factory()
            ->for(
                DiscountCondition::factory()
                    ->for($this->rule, 'rule')
                    ->create([
                        'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE
                    ])
            )
            ->create([
                'site_id' => $this->site->id,
            ]);

        $conditionMemberShip = ConditionMembershipLevel::factory()
            ->for(
                DiscountCondition::factory()
                    ->for($this->rule, 'rule')
                    ->create([
                        'required_code' => 10,
                        'condition_type_id' => DiscountConditionTypes::MEMBERSHIP_EXPIRES_IN_DAYS
                    ])
            )
            ->create();

        Subscription::factory()->create([
            'level_id' => $conditionMemberShip->membershiplevel_id,
            'end_date' => now()->addDay(5)->toDateTimeString()
        ]);

        $this->assertTrue(
            (new CheckDiscountRuleConditions(
                discountEntity: $this->rule,
                account: $this->account,
                cart: Cart::firstOrFactory()
            ))
                ->handle()
        );
    }

    /**
     * @return void
     */
    protected function bulkConditionsCreate(): void
    {
        $requiredAccountCondition = DiscountCondition::factory()->create([
            'rule_id' => $this->rule->id,
            'condition_type_id' => DiscountConditionTypes::REQUIRED_ACCOUNT
        ]);

        ConditionAccountType::factory()
            ->for(DiscountCondition::factory()->create([
                'rule_id' => $this->rule->id,
                'condition_type_id' => DiscountConditionTypes::REQUIRED_ACCOUNT_TYPE
            ]))
            ->create();

        $activeMembershipLevelCondition = DiscountCondition::factory()->create([
            'rule_id' => $this->rule->id,
            'condition_type_id' => DiscountConditionTypes::ACTIVE_MEMBERSHIP_LEVEL
        ]);

        $membershipLevelCondition = ConditionMembershipLevel::factory()
            ->for($activeMembershipLevelCondition)
            ->create();

        Subscription::factory()->create([
            'level_id' => $membershipLevelCondition->membershiplevel_id,
            'end_date' => now()->addDay(5)->toDateTimeString()
        ]);

        $membershipExpiresCondition = DiscountCondition::factory()->create([
            'required_code' => 10,
            'rule_id' => $this->rule->id,
            'condition_type_id' => DiscountConditionTypes::MEMBERSHIP_EXPIRES_IN_DAYS
        ]);

        $siteCondition = DiscountCondition::factory()->create([
            'rule_id' => $this->rule->id,
            'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE
        ]);

        ConditionSite::factory()->create([
            'site_id' => $this->site->id,
            'condition_id' => $siteCondition->id
        ]);
    }
}
