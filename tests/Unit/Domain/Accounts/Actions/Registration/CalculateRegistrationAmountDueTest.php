<?php

namespace Tests\Unit\Domain\Accounts\Actions;

use Domain\Accounts\Actions\Registration\CalculateRegistrationAmountDue;
use Domain\Accounts\Actions\Registration\Order\Cart\StartCartFromRegistration;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Tests\TestCase;


class CalculateRegistrationAmountDueTest extends TestCase
{
    /** @test */
    public function can_update_account_type()
    {
        $product = Product::factory()->create();
        ProductPricing::factory()->create([
            'price_reg' => 10.00,
            'product_id' => $product->id,
            'site_id' => $site = Site::firstOrFactory()
        ]);

        SiteSettings::factory()
            ->for($site)
            ->create();

        $membershipLevel = MembershipLevel::factory()->create([
            'annual_product_id' => $product->id,
        ]);

        $registration = Registration::factory()
            ->create([
                'level_id' => $membershipLevel->id,
            ]);

        $cart = StartCartFromRegistration::now($registration);

        CartDiscountAdvantage::factory(2)
            ->for(
                CartDiscount::factory()
                    ->for($cart)
            )
            ->create([
                'advantage_id' => DiscountAdvantage::factory([
                    'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_ORDER
                ]),
                'amount' => 2.50,
            ]);

        $amount = CalculateRegistrationAmountDue::now($registration);

        $this->assertEquals(5.00, $amount);
    }
}
