<?php


namespace Tests\Feature\Domain\Orders\Actions\Services\Shipping\Ups;


use Domain\Orders\Actions\Services\Shipping\Ups\GenerateNewAccessToken;
use Domain\Orders\Actions\Services\Shipping\Ups\GetAccessTokenDataFromDistributorService;
use Domain\Orders\Actions\Services\Shipping\Ups\GetValidAccessToken;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Domain\Orders\Services\Shipping\Ups\Traits\UsesUpsApiClient;

class GenerateNewTokenTest extends \Tests\TestCase
{
    use UsesUpsApiClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDistributorService();
    }

    /** @test */
    public function can()
    {
        $this->mockNewAccessTokenResponse();

        $this->assertNull(
            GetAccessTokenDataFromDistributorService::now(
                $this->distributorService,
                Modes::Test
            )
        );

        GenerateNewAccessToken::now(
            $this->distributorService,
            Modes::Test
        );

        $this->assertInstanceOf(
            Token::class,
            GetAccessTokenDataFromDistributorService::now(
                $this->distributorService,
                Modes::Test
            )
        );
    }

    /** @test */
    public function can_use_existing()
    {
        $this->distributorService->setCredential(
            Modes::Test->value . '->token',
            (new Token(
                refreshToken: 'test',
                accessToken: 'test',
                tokenType: 'Bearer',
                expiresIn: 3600,
                refreshTokenExpiresIn: 5183999,
                issuedAt: now()->addMinutes(5)->timestamp,
                refreshTokenIssuedAt: now()->addMinutes(5)->timestamp,
                status: 'approved',
                refreshTokenStatus: 'approved',
                clientId: 'test',
            ))->toArray()
        );

        GetValidAccessToken::now(
            $this->distributorService,
            Modes::Test
        );

        Http::assertNothingSent();
    }

    /** @test */
    public function can_detect_expiration()
    {
        $this->mockRefreshTokenResponse();

        $this->distributorService->setCredential(
            Modes::Test->value . '->token',
            (new Token(
                refreshToken: 'test',
                accessToken: 'test',
                tokenType: 'Bearer',
                expiresIn: 3600,
                refreshTokenExpiresIn: 5183999,
                issuedAt: now()->subSeconds(3600)->addSeconds(59)->timestamp,
                refreshTokenIssuedAt: now()->addMinutes(5)->timestamp,
                status: 'approved',
                refreshTokenStatus: 'approved',
                clientId: 'test',
                expiresAt: now()->addSeconds(59),
            ))->toArray()
        );

        $olddistributorService = clone($this->distributorService);

        GetValidAccessToken::now(
            $this->distributorService,
            Modes::Test
        );

        $this->assertNotEquals(
            $olddistributorService->token(Modes::Test)->accessToken,
            $this->distributorService->fresh()->token(Modes::Test)->accessToken,
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
            $this->distributorService,
            Modes::Test
        );
    }
}
