<?php

namespace Domain\Payments\Services\AuthorizeNet;

use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\MerchantAuthenticationType;

class Client
{
    public MerchantAuthenticationType $apiAuth;

    public string $environment = ANetEnvironment::SANDBOX;

    public function __construct(
        string $loginId,
        string $apiKey
    )
    {
        $this->apiAuth = (new MerchantAuthenticationType)
            ->setName($loginId)
            ->setTransactionKey($apiKey);
    }

    public function liveMode(bool $setLive = true): static
    {
        $this->environment = $setLive
            ? ANetEnvironment::PRODUCTION
            : ANetEnvironment::SANDBOX;

        return $this;
    }

    public function transactionRequest(): CreateTransactionRequest
    {
        /** @var CreateTransactionRequest $request */
        $request = resolve(CreateTransactionRequest::class);

        return $request->setMerchantAuthentication($this->apiAuth);
    }
}
