<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Orders\Actions\Order\Transaction\UpdateOrderTransactionFromDto;
use Domain\Orders\Enums\Order\OrderStatuses;
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

class ConfirmPaymentWithPaypal extends AbstractAction
{
    private Order $paypalOrder;
    private OrderTransaction $transaction;

    public function __construct(
        public PaymentRequestData $data
    )
    {
        $this->transaction = $this->data->transaction;
    }

    public function execute(): OrderTransaction
    {
        $this->validate();

        $this->paypalOrder = GetOrder::now(
            ConstructClientFromPaymentAccount::now(
                $this->data->account
            ),
            $this->transaction->transaction_no
        );

        if ($this->paypalOrder->status === PaymentStatuses::Completed) {
            return $this->updateTransaction();
        }

        if ($this->paypalOrder->status !== PaymentStatuses::Approved) {
            throw new \Exception(
                __('Paypal payment is not approved: :status', [
                    'status' => $this->paypalOrder->status->value
                ]),
                Response::HTTP_PRECONDITION_FAILED
            );
        }

        $this->deployJobToCompletePayment();

        return $this->updateTransaction();
    }

    protected function validate(): void
    {
        !$this->transaction->status->isPaid()
            ?: throw new \Exception(
            __('Transaction is already paid'),
            Response::HTTP_LOCKED
        );
    }

    protected function updateTransaction(): OrderTransaction
    {
        UpdateOrderTransactionFromDto::now(
            transaction: $this->transaction,
            dto: ConvertOrderToTransactionDto::now(
                order: $this->paypalOrder,
                amount: $this->data->amount,
                paymentMethod: $this->data->method,
                paymentAccount: $this->data->account,
            )
        );

        $this->data->order->update([
            'payment_status' => $this->transaction->status->toOrderPaymentStatus(),
            'status' => OrderStatuses::PaymentArranged,
        ]);

        return $this->transaction;
    }

    protected function deployJobToCompletePayment(): void
    {
        match ($this->paypalOrder->intent) {
            PaymentIntents::Authorize => AuthorizePaypalPayment::dispatch(
                $this->transaction->id
            ),
            PaymentIntents::Capture => CapturePaypalPayment::dispatch(
                $this->transaction->id
            )
        };
    }
}
