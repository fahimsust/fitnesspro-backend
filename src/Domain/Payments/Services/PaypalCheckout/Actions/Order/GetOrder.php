<?php

namespace Domain\Payments\Services\PaypalCheckout\Actions\Order;

use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Domain\Payments\Services\PaypalCheckout\Enums\Endpoints;
use Support\Contracts\AbstractAction;

class GetOrder extends AbstractAction
{
    public function __construct(
        public Client $client,
        public string    $orderId,
    )
    {
    }

    public function execute(): Order
    {
        return Order::fromApi(
            $this->client
                ->get(
                    uri: Endpoints::Orders
                        ->resolve()
                        ->get($this->orderId)
                )
                ->json()
        );
    }
}
