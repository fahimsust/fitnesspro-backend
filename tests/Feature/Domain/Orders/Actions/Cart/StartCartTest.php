<?php

namespace Tests\Feature\Domain\Orders\Actions\Cart;

use Domain\Accounts\Actions\Registration\Order\Cart\StartCartFromRegistration;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Affiliates\Models\Affiliate;
use Domain\Orders\Actions\Cart\StartCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Payments\Models\PaymentMethod;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Tests\TestCase;

class StartCartTest extends TestCase
{
    /** @test */
    public function can_start_without_account()
    {
        $this->assertDatabaseCount(Cart::class, 0);

        $cart = StartCart::run();

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNull($cart->account);
        $this->assertDatabaseCount(Cart::class, 1);
    }

    /** @test */
    public function can_start_with_account()
    {
        $this->assertDatabaseCount(Cart::class, 0);

        $cart = StartCart::now(account: Account::firstOrFactory());

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotNull($cart->account);
        $this->assertDatabaseCount(Cart::class, 1);
    }

    /** @test */
    public function can_start_from_registration()
    {
        $this->assertDatabaseCount(Cart::class, 0);

        SiteSettings::factory()
            ->for($site = Site::firstOrFactory())
            ->create();

        $productPricing = ProductPricing::factory()
            ->for($site)
            ->create();

        $registration = Registration::factory()
            ->create([
                'level_id' => MembershipLevel::firstOrFactory([
                    'annual_product_id' => $productPricing->product_id,
                ]),
                'affiliate_id' => Affiliate::factory()->create(),
                'payment_method_id' => PaymentMethod::factory()->create(),
            ]);

        $cart = StartCartFromRegistration::now($registration);

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertInstanceOf(Account::class, $cart->account);
        $this->assertDatabaseCount(Cart::class, 1);
        $this->assertModelExists($cart);

        $this->assertDatabaseCount(CartItem::class, 1);
        $cartItem = $cart->items()->first();
        $this->assertInstanceOf(CartItem::class, $cartItem);
        $this->assertModelExists($cartItem);

        $this->assertEquals(
            [
                1,
                $registration->levelCached()->annual_product_id,
            ],
            [
                $cartItem->qty,
                $cartItem->product_id
            ]
        );
    }
}
