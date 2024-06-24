<?php

namespace Domain\Orders\Actions\Services\Shipping\Ups;

use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Support\Contracts\AbstractAction;

class ConstructClientFromDistributorService extends AbstractAction
{
    public function __construct(
        public DistributorUps $service,
        public ?Modes         $mode = null,
        public bool           $generateAccessToken = true
    )
    {
        $this->mode ??= $this->service->getConfig('use_test')
            ? Modes::Test
            : Modes::Live;
    }

    public function execute(): Client
    {
        return new Client(
            clientId: config('services.ups.client_id'),
            clientSecret: config('services.ups.client_secret'),
            mode: $this->mode,
            token: $this->generateAccessToken
                ? GetValidAccessToken::now($this->service, $this->mode)
                : $this->service->token($this->mode)?->accessToken
        );
    }
}
