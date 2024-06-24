<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Accounts\Models\Account;
use Domain\Orders\Exceptions\AccountNotAllowedCheckoutException;
use Domain\Orders\Models\Checkout\Checkout;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class AccountControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToStartCheckout();

        $this->checkout = Checkout::factory()
            ->for($this->account)
            ->for($this->cart)
            ->create();
    }

    /** @test */
    public function can_update()
    {
        $newAccount = Account::factory()->create([
            'membership_status' => true
        ]);
        $this->assertNotEquals(
            $this->checkout->account_id,
            $newAccount->id
        );

        $response = $this->postJson(
            route(
                'checkout.account.update',
                $this->checkout->uuid
            ),
            ['account_id' => $newAccount->id]
        )
            ->assertOk()
            ->assertJsonStructure([
                'checkout' => [
                    'id',
                    'uuid',
                    'status',
                    'comments',
                    'payment_method',
                    'billing_address',
                    'shipping_address',
                    'account',
                    'cart',
                    'order',
                ]
            ]);

        $this->assertEquals(
            $this->checkout->fresh()->account_id,
            $newAccount->id
        );
        $this->assertEquals(
            $newAccount->id,
            $response->json('checkout.account.id')
        );

//        dd($response->json());
    }

    /** @test */
    public function can_error()
    {
        $newAccount = Account::factory()->create([
            'membership_status' => false
        ]);

        $response = $this->postJson(
            route(
                'checkout.account.update',
                $this->checkout->uuid
            ),
            ['account_id' => $newAccount->id]
        )
            ->assertServerError()
            ->assertJsonFragment([
                'exception' => AccountNotAllowedCheckoutException::class
            ]);

//        dd($response->json());
    }
}
