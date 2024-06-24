<?php

namespace Domain\Payments\Jobs\PaypalCheckout;

use Domain\Orders\Actions\Order\LoadOrderById;
use Domain\Orders\Actions\Order\Transaction\LoadOrderTransactionByIdFromCache;
use Domain\Orders\Actions\Order\Transaction\UpdateOrderTransactionFromDto;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Actions\Services\PaypalCheckout\ConstructClientFromPaymentAccount;
use Domain\Payments\Actions\Services\PaypalCheckout\ConvertOrderToTransactionDto;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\AuthorizeOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AuthorizePaypalPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private OrderTransaction $transaction;

    public $tries = 4;

    public $backoff = [60, 120, 300];

    public function __construct(
        public int $orderTransactionId
    )
    {
    }

    public function handle(): void
    {
        $this->transaction = LoadOrderTransactionByIdFromCache::now(
            $this->orderTransactionId
        );

        try {
            $paypalOrder = AuthorizeOrder::now(
                ConstructClientFromPaymentAccount::now(
                    $this->transaction->paymentAccountCached()
                ),
                $this->transaction->transaction_no
            );

            UpdateOrderTransactionFromDto::now(
                transaction: $this->transaction,
                dto: ConvertOrderToTransactionDto::now(
                    order: $paypalOrder,
                    amount: $this->transaction->amount,
                    overrideStatus: OrderTransactionStatuses::Authorized
                )
            );

            LoadOrderById::now($this->transaction->order_id)
                ->activity('Payment authorized with Paypal.');

        } catch (\Throwable $exception) {
            LoadOrderById::now($this->transaction->order_id)
                ->activity('Failed to capture with Paypal: ' . $exception->getMessage());

            throw $exception;
        }
    }
}
