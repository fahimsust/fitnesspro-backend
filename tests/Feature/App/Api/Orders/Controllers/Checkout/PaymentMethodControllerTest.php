<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Checkout;

use Domain\Payments\Models\PaymentMethod;
use Tests\Feature\Traits\TestCheckouts;
use Tests\TestCase;
use function route;

class PaymentMethodControllerTest extends TestCase
{
    use TestCheckouts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepToPayForCheckout();
        $this->checkout->update([
            'payment_method_id' => null
        ]);
    }

    /** @test */
    public function can()
    {
        $this->withoutExceptionHandling();
        $this->assertNull($this->checkout->payment_method_id);

        $methodId = 2;

        $response = $this->postJson(
            route(
                'checkout.payment-method',
                $this->checkout->uuid
            ),
            [
                'payment_method_id' => $methodId,
            ]
        )
            ->assertOk()
            ->assertJsonStructure(['method']);

        $this->assertEquals(
            $this->checkout->fresh()->payment_method_id,
            $methodId
        );

//        dd($response->json());
    }

    /** @test */
    public function can_error()
    {
        $response = $this->postJson(
            route(
                'checkout.payment-method',
                $this->checkout->uuid
            ),
            [
                'payment_method_id' => null
            ]
        )
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('payment_method_id');

//        dd($response->json());
    }
}
