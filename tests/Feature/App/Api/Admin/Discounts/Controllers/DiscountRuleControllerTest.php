<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DiscountRuleControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_discount_rule()
    {
        $discount = Discount::factory()->create();
        $discountRules = DiscountRule::factory(10)->create([
            'discount_id' => $discount->id
        ]);
        foreach ($discountRules as $discountRule) {
            DiscountCondition::factory(10)->create([
                'rule_id' => $discountRule->id
            ]);
        }
        $this->getJson(route('admin.discount-rule.index', ['discount_id' => $discount->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'match_anyall',
                    'conditions' =>
                        ['*' =>
                            [
                                'products',
                                'sites',
                                'countries',
                                'attribute_options',
                                'account_types',
                                'distributors',
                                'product_types',
                                'on_sale_statuses',
                                'out_of_stock_statuses',
                                'product_availabilities'
                            ]
                        ]


                    ]
            ])
            ->assertJsonCount(10);
    }
    /** @test */
    public function can_create_new_discount_rule()
    {
        $discount = Discount::factory()->create();

        $this->postJson(
            route('admin.discount-rule.store'),
            [
                'discount_id' => $discount->id,
                'match_anyall' => true,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(DiscountRule::Table(), 1);
    }

    /** @test */
    public function can_update_discount_rule()
    {
        $discountRule = DiscountRule::factory()->create(['match_anyall' => false, 'rank' => 1]);
        $request = [
            'match_anyall' => true,
            'rank' => 10,
        ];

        $this->putJson(route('admin.discount-rule.update', [$discountRule]), $request)
            ->assertCreated();

        $this->assertDatabaseHas(DiscountRule::Table(), $request);
    }
    /** @test */
    public function can_delete_discount_advantage()
    {
        $discountRules = DiscountRule::factory(5)->create();

        $this->deleteJson(route('admin.discount-rule.destroy', [$discountRules->first()]))
            ->assertOk();

        $this->assertDatabaseCount(DiscountRule::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.discount-rule.store'))
            ->assertJsonValidationErrorFor('discount_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(DiscountRule::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $discount = Discount::factory()->create();

        $this->postJson(
            route('admin.discount-rule.store'),
            [
                'discount_id' => $discount->id,
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(DiscountRule::Table(), 0);
    }
}
