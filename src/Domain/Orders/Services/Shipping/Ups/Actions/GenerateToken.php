<?php

namespace Domain\Orders\Services\Shipping\Ups\Actions;

use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Support\Contracts\AbstractAction;

class GenerateToken extends AbstractAction
{
    public function __construct(
        public Client $client,
        public string $authCode,
        public string $redirectUri
    )
    {
    }

    public function execute(): Token
    {
        return $this->client->generateToken(
            $this->authCode,
            $this->redirectUri
        );
    }
}
