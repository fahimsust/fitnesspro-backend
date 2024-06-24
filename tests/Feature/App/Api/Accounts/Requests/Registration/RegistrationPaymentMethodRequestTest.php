<?php

namespace Tests\Feature\App\Api\Accounts\Requests\Registration;

use App\Api\Accounts\Requests\Registration\RegistrationPaymentMethodRequest;
use App\Api\Accounts\Rules\IsValidSubscriptionPaymentMethod;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Payments\Models\PaymentMethod;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;


class RegistrationPaymentMethodRequestTest extends TestCase
{
    use AdditionalAssertions;

    private RegistrationPaymentMethodRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new RegistrationPaymentMethodRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'payment_method_id' => ['integer','required',new IsValidSubscriptionPaymentMethod],
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->assertTrue($this->request->authorize());
    }

    /** @test */
    public function can_validate_payment_method_and_return_errors()
    {
        $paymentMethod = PaymentMethod::factory()->create(['status'=>0]);
        $registration = Registration::factory()->create();

        $this->postJson(route('registration.payment-method.store'), ['registration_id' => $registration->id,'payment_method_id' => $paymentMethod->id])
            ->assertJsonValidationErrorFor('payment_method_id')
            ->assertJsonFragment(["message" => __('Invalid Payment Method')])
            ->assertStatus(422);

        $this->assertNotEquals($paymentMethod->id, Registration::first()->payment_method_id);
    }


}
