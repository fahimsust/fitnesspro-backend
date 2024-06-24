<?php

namespace Domain\Payments\Dtos;

use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Spatie\LaravelData\Data;

class TransactionDto extends Data
{
    public function __construct(
        public string|int               $id,
        public string                   $amount,

        public ?PaymentMethod           $paymentMethod = null,
        public ?PaymentAccount          $paymentAccount = null,
        public ?int                     $paymentMethodId = null,
        public ?int                     $paymentAccountId = null,

        public OrderTransactionStatuses $status = OrderTransactionStatuses::Created,

        public ?string                  $cardNumber = "0",
        public ?string                  $cardExpiration = "",

        public ?string                  $notes = null,

        public bool                     $captureOnShipment = false,

        public ?CimPaymentProfile       $paymentProfile = null,

        public ?AccountAddress          $accountBillingAddress = null,

        public ?array                   $data = [],
    )
    {
    }

    public function status(OrderTransactionStatuses $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function paymentProfile(CimPaymentProfile $paymentProfile): static
    {
        $this->paymentProfile = $paymentProfile;

        return $this;
    }

    public function cardExpiration(?string $expiration): static
    {
        $this->cardExpiration = $expiration;

        return $this;
    }

    public function toModel(): array
    {
        return [
            'transaction_no' => $this->id,
            'original_amount' => $this->amount,
            'amount' => $this->amount,
            'status' => $this->status,
            'created_at' => now(),

            'notes' => $this->notes,

            'cc_no' => substr($this->cardNumber, -4),
            'cc_exp' => $this->cardExpiration ?? "",

            'billing_address_id' => $this->accountBillingAddress ?? null,

            'payment_method_id' => $this->paymentMethodId ?? $this->paymentMethod?->id,
            'gateway_account_id' => $this->paymentAccountId ?? $this->paymentAccount?->id,

            'cim_payment_profile_id' => $this->paymentProfile?->id ?? null,

            'capture_on_shipment' => $this->captureOnShipment,

            'data' => $this->data,
        ];
    }
}
