<?php

namespace Domain\Orders\Actions\Order\Transaction;


use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Dtos\TransactionDto;
use Support\Contracts\AbstractAction;

class UpdateOrderTransactionFromDto extends AbstractAction
{

    public bool $ignoreNullValues = true;

    public function __construct(
        public OrderTransaction $transaction,
        public TransactionDto $dto
    )
    {
    }

    public function result(): OrderTransaction
    {
        return $this->transaction;
    }

    public function execute(): static
    {
        $this->transaction->update(
            array_filter(
                $this->dto->toModel(),
                fn($value) => !$this->ignoreNullValues || $value !== null
            )
        );

        return $this;
    }
}
