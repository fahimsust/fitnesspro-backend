<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use App\Api\Payments\Contracts\PaymentRequest;
use App\Api\Payments\Requests\PaypalCheckoutRequest;
use Domain\Orders\Actions\Order\Transaction\StartOrFindAlreadyStartedOrderTransaction;
use Domain\Orders\Actions\Order\Transaction\UpdateOrderTransactionFromDto;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Actions\CreatePaymentUrlWithTransactionForFrontend;
use Domain\Payments\Dtos\PaymentRequestData;
use Domain\Payments\Enums\FrontendPaymentActions;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\CreateSimpleOrder;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentIntents;
use Support\Contracts\AbstractAction;
use Support\Dtos\RedirectUrl;

class InitiatePaymentWithPaypal extends AbstractAction
{
    public OrderTransaction $transaction;
    private Order $paypalOrder;

    public function __construct(
        public PaymentRequestData $data
    )
    {
    }

    public function execute(): RedirectUrl
    {
        UpdateOrderTransactionFromDto::now(
            transaction: $this->startTransaction(),
            dto: ConvertOrderToTransactionDto::now(
                order: $this->createOrderInPaypal(),
                amount: $this->data->amount,
                paymentMethod: $this->data->method,
                paymentAccount: $this->data->account,
            )
        );

        $this->data->order->update([
            'payment_status' => $this->transaction->status->toOrderPaymentStatus(),
        ]);

        return new RedirectUrl(
            $this->paypalOrder->links['payer-action']->href
            ?? $this->paypalOrder->links['approve']->href
        );
    }

    protected function request(): PaypalCheckoutRequest|PaymentRequest
    {
        return $this->data->request;
    }

    private function startTransaction(): OrderTransaction
    {
        return $this->transaction = StartOrFindAlreadyStartedOrderTransaction::now(
            $this->data->order,
            amount: $this->data->amount,
            paymentMethod: $this->data->method,
            paymentAccount: $this->data->account,
        );
    }

    private function createOrderInPaypal(): Order
    {
        return $this->paypalOrder = CreateSimpleOrder::now(
            client: ConstructClientFromPaymentAccount::now(
                $this->data->account
            ),
            intent: PaymentIntents::Capture,
            orderNumber: $this->data->order->order_no,
            currencyCode: $this->data->account->currency_code,
            amount: $this->data->amount,
            returnUrl: CreatePaymentUrlWithTransactionForFrontend::now(
                $this->transaction,
                FrontendPaymentActions::Confirm
            ),
            cancelUrl: CreatePaymentUrlWithTransactionForFrontend::now(
                $this->transaction,
                FrontendPaymentActions::Cancel
            ),
        );
    }
}
