<?php

namespace Domain\Payments\Dtos;

use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Spatie\LaravelData\Data;

class PaymentRequestData extends Data
{
    public function __construct(
        public Order             $order,
        public PaymentRequest    $request,
        public PaymentMethod     $method,
        public float             $amount,
        public ?PaymentAccount    $account,
        public ?OrderTransaction $transaction = null,
    )
    {
    }

    public static function fromTransaction(
        OrderTransaction $transaction,
        PaymentRequest   $request
    ): static
    {
        return new self(
            order: $transaction->order,
            request: $request,
            method: $transaction->paymentMethod,
            amount: $transaction->amount,
            account: $transaction->paymentAccount,
            transaction: $transaction,
        );
    }
}
