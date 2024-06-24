<?php

namespace Domain\Orders\Actions\Order\Transaction;

use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadOrderTransactionsByOrderId extends AbstractAction
{
    public function __construct(
        public int  $orderId,
        public bool $useCache = true,
    ) {
    }

    public function execute(): Collection
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'order-transactions-cache.' . $this->orderId,
        ])
            ->remember(
                'load-order-transactions-by-order-id.' . $this->orderId,
                60 * 60,
                fn () => $this->load()
            );
    }

    public function load(): Collection
    {
        return OrderTransaction::query()
            ->with('paymentAccount')
            ->where('order_id', $this->orderId)
            ->get();
    }
}
