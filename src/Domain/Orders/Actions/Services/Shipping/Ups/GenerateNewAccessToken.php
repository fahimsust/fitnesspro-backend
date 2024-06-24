<?php

namespace Domain\Orders\Actions\Services\Shipping\Ups;

use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Services\Shipping\Ups\Actions\GenerateToken;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Support\Contracts\AbstractAction;

class GenerateNewAccessToken extends AbstractAction
{
    public function __construct(
        public DistributorUps $distributorService,
        public Modes $mode
    )
    {
    }

    public function execute(): string
    {
        $token = $this->generateToken();

        $this->distributorService->setCredential($this->mode->value.'->token', $token->toArray());

        return $token->accessToken;
    }

    protected function generateToken(): Token
    {
        return GenerateToken::now(
            ConstructClientFromDistributorService::now(
                $this->distributorService,
                $this->mode,
                false
            ),
            $this->distributorService->getCredential('auth_code', $this->mode),
            config('services.ups.redirect_uri')
        );
    }
}
