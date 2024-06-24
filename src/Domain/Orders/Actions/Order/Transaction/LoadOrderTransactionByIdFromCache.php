<?php

namespace Domain\Orders\Actions\Order\Transaction;

use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadOrderTransactionByIdFromCache extends AbstractAction
{
    public function __construct(
        public int  $id,
    ) {
    }

    public function execute(): OrderTransaction
    {
        return Cache::tags([
            'order-transaction-cache.' . $this->id,
        ])
            ->remember(
                'load-order-transaction-by-id.' . $this->id,
                60 * 5,
                fn () => $this->load()
            );
    }

    public function load(): OrderTransaction
    {
        return OrderTransaction::find($this->id)
            ?? throw new ModelNotFoundException(
                __("No order transaction matching ID :id.", [
                    'id' => $this->id,
                ])
            );
    }
}
