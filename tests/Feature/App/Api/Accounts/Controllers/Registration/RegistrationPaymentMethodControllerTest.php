<?php

namespace Tests\Feature\App\Api\Accounts\Controllers\Registration;

use Domain\Accounts\Actions\Registration\SetRegistrationPaymentMethod;
use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;
use function route;


class RegistrationPaymentMethodControllerTest extends TestCase
{
    public Registration $registration;

    private Collection $paymentMethods;
    private array $paymentMethodStructure;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registration = Registration::factory()->create();

        Site::firstOrFactory(['id' => config('site.id')]);

        SubscriptionPaymentOption::factory(5)->create([
            'site_id' => config('site.id'),
            'payment_method_id' => PaymentMethod::factory(['status' => true])
        ]);

        $this->paymentMethods = PaymentMethod::subscriptionOptions(config('site.id'))->get();

        $this->paymentMethodStructure = [
            'id',
            'name',
            'display',
            'gateway_id',
            'status',
            'limitby_country',
            'feeby_country'
        ];
        session(['registrationId' => $this->registration->id]);
    }

    /** @test */
    public function can_get_payment_methods()
    {
        $this->getJson(route('registration.payment-method.view'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                '*' => $this->paymentMethodStructure
            ]);
    }

    /** @test */
    public function can_select_payment_methods()
    {

        $this->postJson(
            route('registration.payment-method.store'),
            [
                'payment_method_id' => $this->paymentMethods->first()->id,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure($this->paymentMethodStructure);

        $this->assertEquals($this->paymentMethods->first()->id, $this->registration->fresh()->payment_method_id);
    }

    /** @test */
    public function can_return_selected_payment_methods()
    {
        $this->registration->update([
            'payment_method_id' => $this->paymentMethods->first()->id
        ]);

        $this->getJson(route('registration.payment-method.show'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->paymentMethodStructure
            );
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('registration.payment-method.store'), ['payment_method_id' => 0])
            ->assertJsonValidationErrorFor('payment_method_id')
            ->assertStatus(422);

        $this->assertNotEquals($this->paymentMethods->first()->id, Registration::first()->payment_method_id);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(SetRegistrationPaymentMethod::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('registration.payment-method.store'),
            [
                'payment_method_id' => $this->paymentMethods->first()->id
            ]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals($this->paymentMethods->first()->id, Registration::first()->payment_method_id);
    }
}
