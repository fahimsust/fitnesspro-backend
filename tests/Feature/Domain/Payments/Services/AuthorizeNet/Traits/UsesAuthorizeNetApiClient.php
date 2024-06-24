<?php

namespace Tests\Feature\Domain\Payments\Services\AuthorizeNet\Traits;

use Domain\Payments\Services\AuthorizeNet\Actions\ExecuteApiCall;
use Domain\Payments\Services\AuthorizeNet\Client;

trait UsesAuthorizeNetApiClient
{
    protected Client $authNetApiClient;

    protected int $testProfileId = 508168897;
    protected int $testPaymentProfileId = 513137419;

    public function initAuthNetClient(): static
    {
        $this->authNetApiClient = new Client(
            '2s5Ra8BcZL',
            '9xwKUS277c5pTR47'
        );

        return $this;
    }

    public function mockExecuteApi(): \Mockery\Expectation|\Mockery\ExpectationInterface|\Mockery\HigherOrderMessage
    {
        $mock = $this->partialMock(ExecuteApiCall::class);

        $mock->shouldReceive('execute')
            ->once()
            ->andReturnSelf();

        return $mock->shouldReceive('result');
    }
}
