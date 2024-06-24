<?php

namespace Domain\Orders\Actions\Order;


use App\Api\Orders\Resources\Order\OrderTransactionResource;
use App\Api\Payments\Requests\ConfirmPaymentRequest;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Dtos\PaymentRequestData;
use Domain\Payments\Enums\PaymentMethodActions;
use Support\Contracts\AbstractAction;

class ConfirmPaymentForOrderTransaction extends AbstractAction
{
    public function __construct(
        public OrderTransaction      $transaction,
        public ConfirmPaymentRequest $request,
    )
    {
    }

    public function execute(): static
    {
        $this->transaction = PaymentMethodActions::from(
            $this->transaction->paymentMethod->id
        )
            ->confirmPaymentRequest(
                PaymentRequestData::fromTransaction(
                    transaction: $this->transaction,
                    request: $this->request,
                )
            );

        return $this;
    }

    public function result(): OrderTransaction
    {
        return $this->transaction;
    }

    public function resultAsResource(): OrderTransactionResource
    {
        return new OrderTransactionResource($this->transaction);
    }
}
