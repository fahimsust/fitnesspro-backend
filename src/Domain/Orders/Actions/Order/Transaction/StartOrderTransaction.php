<?php

namespace Domain\Orders\Actions\Order\Transaction;


use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class StartOrderTransaction extends AbstractAction
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
        $this->transaction = $this->order
            ->transactions()
            ->create([
                'created_at' => now(),
                'amount' => $this->amount,
                'payment_method_id' => $this->paymentMethod->id,
                'gateway_account_id' => $this->paymentAccount->id,
                'status' => OrderTransactionStatuses::Created,
                'transaction_no' => "",
                'notes' => "",
            ]);

        return $this;
    }
}
