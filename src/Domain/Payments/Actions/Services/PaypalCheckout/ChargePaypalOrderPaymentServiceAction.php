<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Contracts\JumpingPaymentAction;
use Domain\Payments\Contracts\PaymentServiceAction;
use Support\Dtos\RedirectUrl;

class ChargePaypalOrderPaymentServiceAction
    extends PaymentServiceAction
    implements JumpingPaymentAction
{
    public function jump(): RedirectUrl
    {
        return InitiatePaymentWithPaypal::now(
            data: $this->paymentRequestData
        );
    }

    public function confirm(): OrderTransaction
    {
        return ConfirmPaymentWithPaypal::now(
            data: $this->paymentRequestData
        );
    }

    public function cancel(): array
    {
        return CancelPaymentWithPaypal::now(
            data: $this->paymentRequestData
        );
    }
}
