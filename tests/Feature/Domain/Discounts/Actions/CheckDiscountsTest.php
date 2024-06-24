<?php

namespace Tests\Feature\Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Actions\CheckDiscounts;
use Domain\Discounts\Collections\DiscountCollection;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Carts\Cart;
use Domain\Sites\Models\Site;
use Illuminate\Support\Collection;
use Support\Enums\MatchAllAnyInt;
use Tests\TestCase;

class CheckDiscountsTest extends TestCase
{
    public Account $account;
    public Collection $discounts;
    public Collection $discountRules;

    private Site $site;
    private Cart $cart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create(['id' => config('site.id')]);

        $this->discountRules = DiscountRule::factory(3)->create([
            'discount_id' => Discount::factory()
        ]);

        $this->discounts = (new DiscountCollection(
            $this->discountRules->map(
                fn(DiscountRule $discountRule) => $discountRule->discount
            )
        ))->matchOption(MatchAllAnyInt::ALL);

        $this->cart = Cart::firstOrFactory();
    }

    /** @test */
    public function check_all_rule_match()
    {
        $this->discountRules->each(
            fn(DiscountRule $rule) => ConditionSite::factory()
                ->for(DiscountCondition::factory()->create([
                    'rule_id' => $rule->id,
                    'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE
                ]))
                ->create([
                    'site_id' => $this->site->id,
                ])
        );

        $checked = (new CheckDiscounts(
            discounts: $this->discounts,
            cart: $this->cart
        ))->handle();

        $this->assertTrue($checked->failed()->isEmpty());
        $this->assertCount(3, $checked->passed());
        $this->assertInstanceOf(Discount::class, $checked->passed()->first());
    }

    /** @test */
    public function can_fail_all()
    {
        $this->discountRules->each(
            fn(DiscountRule $rule) => ConditionSite::factory()
                ->for(DiscountCondition::factory()->create([
                    'rule_id' => $rule->id,
                    'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE
                ]))
                ->create([
                    'site_id' => $this->site->id,
                ])
        );

        $this->cart->update(['site_id' => Site::factory()->create()->id]);//setting wrong site so it fails

        $checked = (new CheckDiscounts(
            discounts: $this->discounts,
            cart: $this->cart
        ))->handle();

        $this->assertTrue($checked->passed()->isEmpty());
        $this->assertCount(3, $checked->failed());
        $this->assertInstanceOf(Discount::class, $checked->failed()->first());
    }

    /** @test */
    public function can_pass_and_fail()
    {
        $secondSite = Site::factory()->create();
        $rule = $this->discounts->first()->rules->first();
        ConditionSite::factory()
            ->for(DiscountCondition::factory()->create([
                'rule_id' => $rule->id,
                'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE
            ]))
            ->create([
                'site_id' => $secondSite->id,
            ]);

        $rule = $this->discounts->get(1)->rules->first();
        ConditionSite::factory()
            ->for(DiscountCondition::factory()->create([
                'rule_id' => $rule->id,
                'condition_type_id' => DiscountConditionTypes::REQUIRED_SITE
            ]))
            ->create([
                'site_id' => $this->site->id,
            ]);

        $checked = (new CheckDiscounts(
            discounts: $this->discounts,
            cart: $this->cart
        ))->handle();

        $this->assertTrue($checked->hasExceptions());
        $this->assertTrue($checked->passed()->isNotEmpty());
        $this->assertTrue($checked->failed()->isNotEmpty());
    }
}
