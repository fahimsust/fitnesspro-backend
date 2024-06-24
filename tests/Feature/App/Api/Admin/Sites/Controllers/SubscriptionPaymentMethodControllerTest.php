<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Actions\PaymentMethods\AddSubscriptionPaymentMethodToSite;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SubscriptionPaymentMethodControllerTest extends ControllerTestCase
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
    public function can_deactive_subscrtion_payment_method()
    {
        SubscriptionPaymentOption::factory()
            ->create(['payment_method_id' => $this->paymentMethod->id]);

        $this->deleteJson(
            route('admin.site.payment-options.subscription.deactivate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id
            ]
        )
            ->assertOk();

        $this->assertDatabaseCount(SubscriptionPaymentOption::Table(), 0);
    }

    /** @test */
    public function can_get_subscrtion_payment_method()
    {
        SubscriptionPaymentOption::factory(5)->create();
        $this->getJson(
            route('admin.site.payment-options.subscription.get', [$this->site])
        )
            ->assertOk()->assertJsonStructure(
                [
                    '*' => [
                        'site_id',
                        'payment_method_id',
                        'gateway_account_id',
                        'payment_account',
                        'payment_method'
                    ]
                ]
            )->assertJsonCount(5);
    }

    /** @test */
    public function can_active_subscrtion_payment_method()
    {
        $this->postJson(
            route('admin.site.payment-options.subscription.activate', [$this->site]),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id
            ]
        )
            ->assertCreated()->assertJsonStructure(
                [
                    '*' => [
                        'site_id',
                        'payment_method_id',
                        'gateway_account_id'
                    ]
                ]
            );;
        $this->assertDatabaseCount(SubscriptionPaymentOption::Table(), 1);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {

        $this->postJson(
            route('admin.site.payment-options.subscription.activate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => 0
            ]
        )
            ->assertJsonValidationErrorFor('gateway_account_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(SubscriptionPaymentOption::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AddSubscriptionPaymentMethodToSite::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('admin.site.payment-options.subscription.activate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id
            ]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(SubscriptionPaymentOption::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.payment-options.subscription.activate', $this->site),
            [
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(SubscriptionPaymentOption::Table(), 0);
    }
}
