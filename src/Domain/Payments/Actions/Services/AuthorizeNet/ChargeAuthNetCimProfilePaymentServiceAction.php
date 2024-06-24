<?php

namespace Domain\Payments\Actions\Services\AuthorizeNet;

use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Payments\Contracts\NonJumpingPaymentAction;
use Domain\Payments\Contracts\PaymentServiceAction;
use Domain\Payments\Dtos\TransactionDto;

class ChargeAuthNetCimProfilePaymentServiceAction
    extends PaymentServiceAction
    implements NonJumpingPaymentAction
{
    private CimPaymentProfile $paymentProfile;

    public function charge(): TransactionDto|bool
    {
        return ChargeAuthorizeNetPaymentProfile::now(
            $this->paymentRequestData->account,
            $this->getPaymentProfile(),
            $this->paymentIdentifier,
            $this->paymentRequestData->amount
        )
            ->toTransactionDto(
                $this->paymentRequestData->amount,
                $this->paymentRequestData->method,
                $this->paymentRequestData->account
            )
            ->status(OrderTransactionStatuses::Captured)
            ->paymentProfile($this->paymentProfile)
            ->cardExpiration($this->paymentProfile->expiration());
    }

    protected function getPaymentProfile(): CimPaymentProfile
    {
        return $this->paymentProfile ??= LoadCimPaymentProfileById::now(
            $this->paymentRequestData->request->payment_profile_id
        );
    }
}
