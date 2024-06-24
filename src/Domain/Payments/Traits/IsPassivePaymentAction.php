<?php

namespace Domain\Payments\Traits;

use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Payments\Dtos\TransactionDto;

trait IsPassivePaymentAction
{
    public function charge(): TransactionDto|bool
    {
        $this->order()->update([
            'payment_status' => OrderPaymentStatuses::InTransit,
            'status' => OrderStatuses::PaymentArranged
        ]);

        return true;
    }
}
