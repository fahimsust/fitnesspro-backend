<?php

namespace Domain\Payments\Services\AuthorizeNet\ValueObjects;

use Domain\Payments\Services\AuthorizeNet\Client;
use net\authorize\api\contract\v1\CreateTransactionRequest;

class ChargeRequestVO
{
    public function __construct(
        public Client                     $client,
        public CreateTransactionRequest   $request,
        public string                     $amount,
    )
    {
    }
}
