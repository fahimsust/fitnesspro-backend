<?php

namespace Domain\Orders\Actions\Services\Shipping\Ups;

use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Support\Contracts\AbstractAction;

class GetValidAccessToken extends AbstractAction
{
    public function __construct(
        public DistributorUps $service,
        public Modes $mode
    )
    {
    }

    public function execute(): string
    {
        $token = $this->getToken();

        if (!$token) {
            return GenerateNewAccessToken::now(
                $this->service,
                $this->mode
            );
        }

        if (!$token->isExpired()) {
            return $token->accessToken;
        }

        return RefreshAccessToken::now(
            $this->service,
            $this->mode
        );
    }

    private function getToken(): ?Token
    {
        return GetAccessTokenDataFromDistributorService::now(
            $this->service,
            $this->mode
        );
    }
}
