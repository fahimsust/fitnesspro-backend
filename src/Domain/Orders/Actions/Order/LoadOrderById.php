<?php

namespace Domain\Orders\Actions\Order;

use Domain\Orders\Exceptions\OrderNotFoundException;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadOrderById extends AbstractAction
{
    public function __construct(
        public int  $orderId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Order
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'order-cache.' . $this->orderId,
        ])
            ->remember(
                'load-order-by-id.' . $this->orderId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Order
    {
        return Order::find($this->orderId)
            ?? throw new OrderNotFoundException(
                __("No order matching ID :id.", [
                    'id' => $this->orderId
                ])
            );
    }
}
