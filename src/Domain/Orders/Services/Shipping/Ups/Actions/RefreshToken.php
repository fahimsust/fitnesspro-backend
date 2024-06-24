<?php

namespace Domain\Orders\Services\Shipping\Ups\Actions;

use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Support\Contracts\AbstractAction;

class RefreshToken extends AbstractAction
{
    public function __construct(
        public Client $client,
        public string $refreshToken,
    )
    {
    }

    public function execute(): Token
    {
        return $this->client->refreshToken($this->refreshToken);
    }
}
