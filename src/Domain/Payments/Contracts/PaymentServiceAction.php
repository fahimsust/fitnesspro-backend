<?php

namespace Domain\Payments\Contracts;

use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Orders\Actions\Order\Transaction\CreateOrderTransactionFromDto;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Dtos\PaymentRequestData;
use Domain\Payments\Dtos\TransactionDto;
use Domain\Payments\Models\PaymentAccount;
use Support\Dtos\RedirectUrl;

abstract class PaymentServiceAction
{
    public string $paymentIdentifier = '';

    public function __construct(
        public PaymentRequestData $paymentRequestData
    )
    {
    }

    public function initiate(): OrderTransaction|RedirectUrl|true
    {
        $this->validate();

        $this->paymentIdentifier = __("Order Id :id", [
            'id' => $this->order()->id
        ]);

        if (in_array(JumpingPaymentAction::class, class_implements($this))) {
            //jumping payment action
            return $this->jump();
        }

        $chargeResult = $this->charge();

        if ($chargeResult instanceof TransactionDto) {
            $this->order()->update([
                'payment_status' => $chargeResult->status->toOrderPaymentStatus(),
                'status' => OrderStatuses::PaymentArranged,
            ]);

            return CreateOrderTransactionFromDto::now(
                $this->order(),
                $chargeResult
            );
        }

        return $chargeResult;
    }

    protected function validate(): static
    {
        $this->request()->validate(
            $this->request()->rules(),
            $this->request()->all()
        );

        return $this;
    }

    protected function paymentAccount(): PaymentAccount
    {
        return $this->paymentRequestData->account;
    }

    protected function paymentMethod(): PaymentAccount
    {
        return $this->paymentRequestData->account;
    }

    protected function order(): Order
    {
        return $this->paymentRequestData->order;
    }

    protected function amount(): float
    {
        return $this->paymentRequestData->amount;
    }

    protected function request(): PaymentRequest
    {
        return $this->paymentRequestData->request;
    }
}
