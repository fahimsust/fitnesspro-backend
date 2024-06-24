<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Payments\Dtos\TransactionDto;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentIntents;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentStatuses;
use Support\Contracts\AbstractAction;

class ConvertOrderToTransactionDto extends AbstractAction
{
    public function __construct(
        public Order           $order,
        public string         $amount,
        public ?PaymentMethod  $paymentMethod = null,
        public ?PaymentAccount $paymentAccount = null,
        public ?OrderTransactionStatuses $overrideStatus = null,
    )
    {
    }

    public function execute(): TransactionDto
    {
        return new TransactionDto(
            id: $this->order->id,
            amount: $this->amount,
            paymentMethod: $this->paymentMethod,
            paymentAccount: $this->paymentAccount,
            status: $this->convertStatus(),
            data: $this->order->toArray(),
        );
    }

    private function convertStatus(): OrderTransactionStatuses
    {
        if($this->overrideStatus) {
            return $this->overrideStatus;
        }

        return match ($this->order->status) {
            PaymentStatuses::Voided => OrderTransactionStatuses::Voided,
            PaymentStatuses::Approved => OrderTransactionStatuses::Approved,
            PaymentStatuses::Completed => match ($this->order->intent) {
                PaymentIntents::Authorize => OrderTransactionStatuses::Authorized,
                PaymentIntents::Capture => OrderTransactionStatuses::Captured,
            },
            default => OrderTransactionStatuses::Pending,
        };
    }
}
