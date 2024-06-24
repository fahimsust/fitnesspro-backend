<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Country;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DiscountAdvantageControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

     /** @test */
     public function can_get_option()
     {
         $this->getJson(route('admin.advantage-options.index'))
             ->assertOk()
             ->assertJsonStructure([
                 '*' => [
                     'id',
                     'name',
                 ]
             ])
             ->assertJsonCount(count(DiscountAdvantageTypes::cases()));
     }
    /** @test */
    public function can_create_new_discount_advantage()
    {
        $discount = Discount::factory()->create();

        $this->postJson(route('admin.discount-advantage.store'),
        [
            'discount_id'=>$discount->id,
            'advantage_type_id'=>DiscountAdvantageTypes::AMOUNT_OFF_ORDER->value
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(DiscountAdvantage::Table(), 1);
    }

    /** @test */
    public function can_update_discount_advantage()
    {
        $discountAdvantage = DiscountAdvantage::factory()->create();
        $shippingMethod = ShippingMethod::factory()->create();
        $country = Country::factory()->create();
        $distributor = Distributor::factory()->create();
        $request = [
            'amount'=>10,
            'apply_shipping_id'=> $shippingMethod->id,
            'apply_shipping_country'=>$country->id,
            'apply_shipping_distributor'=>$distributor->id,
            'applyto_qty_type'=>0,
            'applyto_qty_combined'=>1
        ];

        $this->putJson(route('admin.discount-advantage.update', [$discountAdvantage]),$request)
            ->assertCreated();

        $this->assertDatabaseHas(DiscountAdvantage::Table(),$request);
    }
    /** @test */
    public function can_get_discount_advantage()
    {
        $discount = Discount::factory()->create();
        DiscountAdvantage::factory(10)->create(['discount_id'=> $discount->id]);
        $discount_other = Discount::factory()->create();
        DiscountAdvantage::factory(15)->create(['discount_id'=> $discount_other->id]);

        $this->getJson(
            route('admin.discount-advantage.index',[
                'discount_id'=> $discount->id,
            ]),

        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'advantage_type_id',
                    'amount',
                    'apply_shipping_id',
                    'apply_shipping_country',
                    'apply_shipping_distributor',
                    'applyto_qty_type',
                    'applyto_qty_combined',
                    'target_products',
                    'target_product_types'
                ]
            ])->assertJsonCount(10);
    }
    /** @test */
    public function can_delete_discount_advantage()
    {
        $discountAdvantages = DiscountAdvantage::factory(5)->create();

        $this->deleteJson(route('admin.discount-advantage.destroy', [$discountAdvantages->first()]))
            ->assertOk();

        $this->assertDatabaseCount(DiscountAdvantage::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.discount-advantage.store'),
        [
            'advantage_type_id'=>DiscountAdvantageTypes::AMOUNT_OFF_ORDER->value
        ])
            ->assertJsonValidationErrorFor('discount_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(DiscountAdvantage::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $discount = Discount::factory()->create();

        $this->postJson(route('admin.discount-advantage.store'),
        [
            'discount_id'=>$discount->id,
            'advantage_type_id'=>DiscountAdvantageTypes::AMOUNT_OFF_ORDER->value
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(DiscountAdvantage::Table(), 0);
    }
}
