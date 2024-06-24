<?php


namespace Tests\Feature\Domain\Payments\Actions\PaypalCheckout;


use Domain\Payments\Actions\Services\PaypalCheckout\GenerateNewAccessToken;
use Domain\Payments\Actions\Services\PaypalCheckout\GetAccessTokenDataFromPaymentAccount;
use Domain\Payments\Actions\Services\PaypalCheckout\GetValidAccessToken;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\PaypalCheckout\DataObjects\AccessToken;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class GenerateNewTokenTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    private PaymentMethod $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAccount();
        $this->paymentMethod = PaymentMethod::firstOrFactory();
    }

    /** @test */
    public function can()
    {
        $this->mockNewAccessTokenResponse();

        $this->assertNull(
            GetAccessTokenDataFromPaymentAccount::now(
                $this->paymentAccount,
                PaypalModes::Sandbox
            )
        );

        GenerateNewAccessToken::now(
            $this->paymentAccount,
            PaypalModes::Sandbox
        );

        $this->assertInstanceOf(
            AccessToken::class,
            GetAccessTokenDataFromPaymentAccount::now(
                $this->paymentAccount,
                PaypalModes::Sandbox
            )
        );
    }

    /** @test */
    public function can_use_existing()
    {
        $this->paymentAccount->credentials(PaypalModes::Sandbox->value.'->token', [
            'access_token' => 'test',
            'expiration' => now()->addMinutes(5)->toIso8601String(),
            'expires_in' => 3600,
            'token_type' => 'Bearer',
            'scope' => 'https://uri.paypal.com/services/invoicing https://uri.paypal.com/services/disputes/read-buyer https://uri.paypal.com/services/payments/realtimepayment https://uri.paypal.com/services/disputes/update-seller https://uri.paypal.com/services/payments/payment/authcapture openid https://uri.paypal.com/services/disputes/read-seller https://uri.paypal.com/services/payments/refund https://api.paypal.com/v1/vault/credit-card https://api.paypal.com/v1/payments/.* https://uri.paypal.com/services/subscriptions https://api.paypal.com/v1/vault/credit-card/.*',
            'nonce' => '2021-09-28T15:00:00Z',
            'app_id' => 'APP-80W284485P519543T',
        ]);

        GetValidAccessToken::now(
            $this->paymentAccount,
            PaypalModes::Sandbox
        );

        Http::assertNothingSent();
    }

    /** @test */
    public function can_detect_expiration()
    {
        $this->mockNewAccessTokenResponse();

        $this->paymentAccount->credentials(PaypalModes::Sandbox->value.'->token', [
            'access_token' => 'test',
            'expiration' => now()->addSeconds(59)->toIso8601String(),
            'expires_in' => 3600,
            'token_type' => 'Bearer',
            'scope' => 'https://uri.paypal.com/services/invoicing https://uri.paypal.com/services/disputes/read-buyer https://uri.paypal.com/services/payments/realtimepayment https://uri.paypal.com/services/disputes/update-seller https://uri.paypal.com/services/payments/payment/authcapture openid https://uri.paypal.com/services/disputes/read-seller https://uri.paypal.com/services/payments/refund https://api.paypal.com/v1/vault/credit-card https://api.paypal.com/v1/payments/.* https://uri.paypal.com/services/subscriptions https://api.paypal.com/v1/vault/credit-card/.*',
            'nonce' => '2021-09-28T15:00:00Z',
            'app_id' => 'APP-80W284485P519543T',
        ]);

        $oldPaymentAccount = clone($this->paymentAccount);

        GetValidAccessToken::now(
            $this->paymentAccount,
            PaypalModes::Sandbox
        );

        $this->assertNotEquals(
            $oldPaymentAccount->credentials[PaypalModes::Sandbox->value]['token']['access_token'],
            $this->paymentAccount->credentials[PaypalModes::Sandbox->value]['token']['access_token'],
        );

        Http::assertSentCount(1);
    }

    /** @test */
    public function can_handle_failure()
    {
        Http::fakeSequence('*')
            ->push(null, 400);

        $this->expectException(RequestException::class);

        GenerateNewAccessToken::now(
            $this->paymentAccount,
            PaypalModes::Sandbox
        );
    }
}
