<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Orders\Actions\Order\Transaction\UpdateOrderTransactionFromDto;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Dtos\PaymentRequestData;
use Domain\Payments\Jobs\PaypalCheckout\AuthorizePaypalPayment;
use Domain\Payments\Jobs\PaypalCheckout\CapturePaypalPayment;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\GetOrder;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentIntents;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentStatuses;
use Support\Contracts\AbstractAction;
use Symfony\Component\HttpFoundation\Response;

class CancelPaymentWithPaypal extends AbstractAction
{
    private OrderTransaction $transaction;

    public function __construct(
        public PaymentRequestData $data
    )
    {
        $this->transaction = $this->data->transaction;
    }

    public function execute(): array
    {
        $this->validate();

        $this->transaction->delete();

        return [
            'message' => __('Payment was canceled'),
        ];
    }

    protected function validate(): void
    {
        !$this->transaction->status->isPaid()
            ?: throw new \Exception(
            __('Transaction is already paid'),
            Response::HTTP_LOCKED
        );
    }
}
