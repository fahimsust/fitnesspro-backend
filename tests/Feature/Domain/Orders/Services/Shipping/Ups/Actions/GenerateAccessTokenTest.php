<?php


namespace Tests\Feature\Domain\Orders\Services\Shipping\Ups\Actions;


use Domain\Orders\Services\Shipping\Ups\Actions\GenerateToken;
use Domain\Orders\Services\Shipping\Ups\Actions\RefreshToken;
use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Tests\Feature\Domain\Orders\Services\Shipping\Ups\Traits\UsesUpsApiClient;

class GenerateAccessTokenTest extends \Tests\TestCase
{
    use UsesUpsApiClient;

    /** @test */
    public function can()
    {
//        \Http::allowStrayRequests();
        $this->mockNewAccessTokenResponse();

//        Client::$dumpResponse = true;
        $this->initUpsClient();

        $result = GenerateToken::now(
            $this->upsApiClient,
            "a3RHOUp2VkEtVTJGc2RHVmtYMSszWlI1aWp1YnpkSzY2aWxuOHVOcDI0NWFWd0I0Wm1sOFdQZUk5NVczcllWMFhPajJvSCtPb1hRSW15UEVHUW9VRDFQdmtLbmZNb2c9PQ==",
            config('services.ups.redirect_uri')
        );

        $this->assertNotEmpty($result->accessToken);
        $this->assertInstanceOf(Token::class, $result);
//        $this->assertFalse($result->isExpired());
    }

    /** @test */
    public function can_refresh()
    {
//        \Http::allowStrayRequests();
        $this->mockRefreshTokenResponse();

//        Client::$dumpResponse = true;
        $this->initUpsClient(
            $oldToken = "eyJraWQiOiI2NGM0YjYyMC0yZmFhLTQzNTYtYjA0MS1mM2EwZjM2Y2MxZmEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzM4NCJ9.eyJzdWIiOiJmaXRsYXVuY2hAY29tY2FzdC5uZXQiLCJjbGllbnRpZCI6IkYxczdva0J4a25Dd0taUWowNEY3a0J3R3hza09NRkV6N2NzMWkyN0pVcmV0VGpRUCIsImlzcyI6Imh0dHBzOi8vYXBpcy51cHMuY29tIiwidXVpZCI6IjM1OTQyNTIyLTFBQjctMUIyNi1COERCLTNDNzMyMUU2NzhFNyIsInNpZCI6IjY0YzRiNjIwLTJmYWEtNDM1Ni1iMDQxLWYzYTBmMzZjYzFmYSIsImF1ZCI6IjIwMjMgZS1jb21tZXJjZSIsImF0IjoiM0xwR3FROGhvWHBlYjlYbERHZzZFcW94aWEzNSIsIm5iZiI6MTcwNDM5MjE5NSwiRGlzcGxheU5hbWUiOiIyMDIzIGUtY29tbWVyY2UiLCJleHAiOjE3MDQ0MDY1OTUsImlhdCI6MTcwNDM5MjE5NSwianRpIjoiODIxNjlhYWItN2QyZS00Nzc5LTlmYjUtOTVjMjFkYTU1MjI0In0.OHDPuBkOAdoZgQqwPq5VogX_-KH0r2hB0ueb9a7t20NOFBkMWV3gjqfpL1CJniV_GSPuKb04fWpjqFcu7hwSm-BDqzMmVg5PRZ5TlH4Jl4xcz40LvbY0hQZJQfhA6OFuTgoyXd31lPr0E-0njlIDKs6638fnq1YrMKAX_xgalnfuG-2rrRa4dolxLzxgxCIoQ_SbdBSswXz2zWqWb90n7vj7vcyiR6pFHWmP2jm6bBYltmQkkyp3KKvyDL2KiuTlgrxRk1uEcsMk4mOinYLdLE8JHf4Qi6Hm0uJhIjPgJdfGiOnwqoBfcDY4BmGhpfvGx884lncvowo0bJTOouAcCZlEo6tLI9RxsrJ2XOBpd8gHzUXb6C7mCuT5ZF_wX20TKXzCGlnmVtk5BF0_VDXJC4bksmmiDX59ZDr-1G6XsArZU8QtYhhR5_p3n6raiGK0EsYoTiOIKKH369-P9CxdHnh5dp3M7mh0AXL3aJ8ky36femlA1NUhlrEUlDBldiF0URiZC-qBrHGVxgo9fjs8Y-0168I_MiBRuj-PajF95dZsNF7xKWs5_4GfC0wprkNwK2ynXSGMqWbJAcjf591NREnViUsdcI7S0ep_Vlt36CUFDF0H4vyCS-wG3aN6B57FX4p5n8BJVnPnLStrElKvGfOqkcVK6KyV15lrsFdJIUI"
        );

        $result = RefreshToken::now(
            $this->upsApiClient,
            "d1RiQUFoRzJ6QndBSWZJVlRxYU91T2pyazhxamFFMUctVTJGc2RHVmtYMS9HclFncmthYi9ZOVE5NHU2NUQ2RFBxcXNpVVh5MEEvOHVuMCtrdGduVHMyU0RSM3dnMGpCZzM4STU5ckFRdG5TRk44VXVwRUs0ekE9PQ==",
        );

        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEquals($oldToken, $result->accessToken);
        $this->assertInstanceOf(Token::class, $result);
        $this->assertFalse($result->isExpired());
    }
}
