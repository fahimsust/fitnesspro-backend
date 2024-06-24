<?php

namespace Domain\Orders\Actions\Order\Transaction;


use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class StartOrFindAlreadyStartedOrderTransaction extends AbstractAction
{
    private OrderTransaction|Model $transaction;

    public function __construct(
        public Order          $order,
        public float          $amount,
        public PaymentMethod  $paymentMethod,
        public PaymentAccount $paymentAccount,
    )
    {
    }

    public function result(): OrderTransaction
    {
        return $this->transaction;
    }

    public function execute(): static
    {
        $this->transaction = $this->findExisting()
            ?? StartOrderTransaction::now(
                order: $this->order,
                amount: $this->amount,
                paymentMethod: $this->paymentMethod,
                paymentAccount: $this->paymentAccount,
            );

        return $this;
    }

    private function findExisting(): ?OrderTransaction
    {
        return FindAlreadyStartedOrderTransaction::now(
            order: $this->order,
            amount: $this->amount,
            paymentMethod: $this->paymentMethod,
            paymentAccount: $this->paymentAccount,
        );
    }
}
