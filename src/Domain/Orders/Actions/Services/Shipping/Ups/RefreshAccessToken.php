<?php

namespace Domain\Orders\Actions\Services\Shipping\Ups;

use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Services\Shipping\Ups\Actions\GenerateToken;
use Domain\Orders\Services\Shipping\Ups\Actions\RefreshToken;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Support\Contracts\AbstractAction;

class RefreshAccessToken extends AbstractAction
{
    public function __construct(
        public DistributorUps $distributorService,
        public Modes $mode
    )
    {
    }

    public function execute(): string
    {
        $token = $this->refreshToken();

        $this->distributorService->setCredential(
            $this->mode->value.'->token',
            $token->toArray()
        );

        return $token->accessToken;
    }

    protected function refreshToken(): Token
    {
        return RefreshToken::now(
            ConstructClientFromDistributorService::now(
                $this->distributorService,
                $this->mode,
                false
            ),
            $this->distributorService->token($this->mode)->refreshToken
        );
    }
}
