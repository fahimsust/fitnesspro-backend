<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Actions\PaymentMethods\AddCheckoutPaymentMethod;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CheckoutPaymentMethodControllerTest extends ControllerTestCase
{
    public Site $site;
    public PaymentMethod $paymentMethod;
    public PaymentAccount $paymentAccount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->paymentMethod = PaymentMethod::factory()->create();
        $this->paymentAccount = PaymentAccount::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_deactive_checkout_payment_method()
    {
        SitePaymentMethod::factory()->create();

        $this->deleteJson(
            route('admin.site.payment-options.checkout.deactivate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id,
                'fee'=>100
            ]
        )
            ->assertOk();

        $this->assertDatabaseCount(SitePaymentMethod::Table(), 0);
    }

    /** @test */
    public function can_get_checkout_payment_method()
    {
        SitePaymentMethod::factory()->create();
        $this->getJson(
            route('admin.site.payment-options.checkout.get', [$this->site])
        )
            ->assertOk()->assertJsonStructure(
                [
                    '*' => [
                        'site_id',
                        'payment_method_id',
                        'gateway_account_id',
                        'fee',
                        'payment_account',
                        'payment_method'
                    ]
                ]
            )->assertJsonCount(1);
    }
    /** @test */
    public function can_update_checkout_payment_method()
    {
        SitePaymentMethod::factory()->create(['fee'=>20]);
        $this->putJson(
            route('admin.site.payment-options.checkout.update', [$this->site]),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id,
                'fee'=>100
            ]
        )
            ->assertCreated();
        $this->assertEquals(100,SitePaymentMethod::first()->fee);
    }

    /** @test */
    public function can_active_checkout_payment_method()
    {
        $this->postJson(
            route('admin.site.payment-options.checkout.activate', [$this->site]),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id,
                'fee'=>100
            ]
        )
            ->assertCreated()->assertJsonStructure(
                [
                    '*' => [
                        'site_id',
                        'payment_method_id',
                        'gateway_account_id',
                        'fee',
                    ]
                ]
            );;
        $this->assertDatabaseCount(SitePaymentMethod::Table(), 1);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {

        $this->postJson(
            route('admin.site.payment-options.checkout.activate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => 0
            ]
        )
            ->assertJsonValidationErrorFor('gateway_account_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(SitePaymentMethod::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AddCheckoutPaymentMethod::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('admin.site.payment-options.checkout.activate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id,
                'fee'=>100
            ]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(SitePaymentMethod::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.payment-options.checkout.activate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id,
                'fee'=>100
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(SitePaymentMethod::Table(), 0);
    }
}
