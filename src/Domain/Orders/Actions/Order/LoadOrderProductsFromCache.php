<?php

namespace Domain\Orders\Actions\Order;

use Domain\Orders\Exceptions\OrderNotFoundException;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadOrderProductsFromCache extends AbstractAction
{
    public function __construct(
        public Order  $order,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Collection
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'order-cache.' . $this->order->id,
        ])
            ->remember(
                'load-order-products.' . $this->order->id,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Collection
    {
        return $this->order->itemsWithProduct()->get();
    }
}
