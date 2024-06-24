<?php

namespace Domain\Orders\Actions\Order\Account;

use Domain\Accounts\Models\Account;
use Domain\Orders\Actions\Order\AddOrderActivity;
use Domain\Orders\Models\Order\Order;
use Support\Contracts\AbstractAction;

class UnassignAccountFromOrder extends AbstractAction
{

    public function __construct(
        public Order $order,
        public Account $account
    ) {
    }

    public function execute(): void
    {
        if(!$this->order->belongsTo($this->account)) {
            throw new \Exception("Account does not belong to order");
        }

        $this->order->update(['account_id' => null]);

        AddOrderActivity::now(
            $this->order,
            "Unassign account " . $this->account->id
        );
    }
}
