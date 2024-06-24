<?php

namespace Domain\Orders\Actions\Order\Transaction;


use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Dtos\TransactionDto;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\AbstractAction;

class CreateOrderTransactionFromDto extends AbstractAction
{
    private OrderTransaction|Model $transaction;

    public function __construct(
        public Order $order,
        public TransactionDto $transactionDto
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
            ->create(
                $this->transactionDto->toModel()
            );

        return $this;
    }
}
