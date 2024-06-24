<?php

namespace Tests\Unit\Domain\Accounts\Models;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Models\Carts\Cart;
use Domain\Products\Models\Product\Product;
use Tests\UnitTestCase;

class RegistrationTest extends UnitTestCase
{
    private Registration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registration = Registration::factory()->create([
            'level_id' => MembershipLevel::firstOrFactory()
        ]);
    }

    /** @test */
    public function get_level_with_product()
    {
        $this->assertInstanceOf(
            MembershipLevel::class,
            $this->registration->levelWithProductCached()
        );

        $this->assertInstanceOf(
            Product::class,
            $this->registration->levelWithProductCached()->product
        );
    }

    /** @test */
    public function get_cart()
    {
        $this->registration->update([
            'cart_id' => Cart::factory(['is_registration' => true])->create()->id
        ]);

        $this->assertInstanceOf(
            Cart::class,
            $this->registration->cart
        );
    }
}
