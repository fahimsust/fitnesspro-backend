<?php

namespace Domain\Orders\Actions\Order\Transaction;


use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Support\Contracts\AbstractAction;

class FindAlreadyStartedOrderTransaction extends AbstractAction
{
    public function __construct(
        public Order          $order,
        public float          $amount,
        public PaymentMethod  $paymentMethod,
        public PaymentAccount $paymentAccount,
    )
    {
    }

    public function execute(): ?OrderTransaction
    {
        return $this->order->transactions()
            ->where('amount', $this->amount)
            ->where('payment_method_id', $this->paymentMethod->id)
            ->where('gateway_account_id', $this->paymentAccount->id)
            ->where('status', OrderTransactionStatuses::Created)
            ->where('created_at', '>', now()->subMinutes(10))
            ->first();
    }
}
