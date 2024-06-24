<?php

namespace Domain\Payments\Services\PaypalCheckout\Actions;

use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\AccessToken;
use Support\Contracts\AbstractAction;

class GenerateNewAccessToken extends AbstractAction
{
    public function __construct(
        public Client $client,
    )
    {
    }

    public function execute(): AccessToken
    {
        return AccessToken::fromApi(
            $this->client
                ->requestToken()
                ->json()
        );
    }
}
