<?php


namespace Tests\Feature\Domain\Payments\Services\PaypalCheckout\Actions;


use Domain\Payments\Services\PaypalCheckout\Actions\GenerateNewAccessToken;
use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\AccessToken;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class GenerateAccessTokenTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    /** @test */
    public function can_charge_profile()
    {
        $this->mockNewAccessTokenResponse();

//        Client::$dumpResponse = true;
        $this->initPaypalClient();

        $result = GenerateNewAccessToken::now(
            $this->paypalApiClient
        );

        $this->assertNotEmpty($result->access_token);
        $this->assertInstanceOf(AccessToken::class, $result);
    }
}
