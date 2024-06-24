<?php

namespace Domain\Orders\Actions\Order;


use App\Api\Payments\Requests\CancelPaymentRequest;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Dtos\PaymentRequestData;
use Domain\Payments\Enums\PaymentMethodActions;
use Support\Contracts\AbstractAction;

class CancelPaymentForOrderTransaction extends AbstractAction
{
    public function __construct(
        public OrderTransaction      $transaction,
        public CancelPaymentRequest $request,
    )
    {
    }

    public function execute(): array
    {
        return PaymentMethodActions::from(
            $this->transaction->paymentMethod->id
        )
            ->cancelPaymentRequest(
                PaymentRequestData::fromTransaction(
                    transaction: $this->transaction,
                    request: $this->request,
                )
            );
    }
}
