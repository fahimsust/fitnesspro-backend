<?php

namespace Domain\Accounts\Actions\Registration;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Actions\Order\Transaction\LoadOrderTransactionsByOrderId;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Support\Contracts\AbstractAction;

class IsRegistrationPaid extends AbstractAction
{
    private Registration $registration;

    public function __construct(
        public int  $registrationId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): bool
    {
        $this->registration = LoadRegistrationById::now(
            $this->registrationId,
        );

        $amountCaptured = 0;

        LoadOrderTransactionsByOrderId::now(
            $this->registration->order_id,
        )
            ->filter(
                $this->capturedOnly(...)
            )
            ->each(
                function (OrderTransaction $transaction) use (&$amountCaptured) {
                    $amountCaptured = bcadd($amountCaptured, $transaction->amount);
                }
            );

        return $amountCaptured >= $this->registration->cartCached()->total();
    }

    protected function capturedOnly(OrderTransaction $transaction): bool
    {
        return $transaction->status === OrderTransactionStatuses::Captured;
    }
}
