<?php

namespace Domain\Orders\Actions\Services\Shipping\Ups;

use Domain\Distributors\Models\Shipping\DistributorUps;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Support\Contracts\AbstractAction;

class GetAccessTokenDataFromDistributorService extends AbstractAction
{
    public function __construct(
        public DistributorUps $service,
        public Modes          $mode
    )
    {
    }

    public function execute(): ?Token
    {
        return $this->service->token($this->mode);
    }
}
