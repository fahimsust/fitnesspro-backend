<?php

namespace Domain\Payments\Services\AuthorizeNet\DataObjects;

use Domain\Payments\Dtos\TransactionDto;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use net\authorize\api\contract\v1\TransactionResponseType;
use Spatie\LaravelData\Data;

class TransactionDO extends Data
{
    public TransactionResponseType $response;

    public static function fromTransactionResponseType(
        TransactionResponseType $response
    )
    {
        return self::from([
            'response' => $response
        ]);
    }

    public function id(): string
    {
        return $this->response->getTransId();
    }

    public function creditCardNumber(): ?string
    {
        if(!$this->response->getAccountNumber())
            return null;

        return substr($this->response->getAccountNumber(), -4);
    }

    public function creditCardExpiration(): ?string
    {
        return null;
    }

    public function paymentProfileId(): ?string
    {
        return $this->response?->getProfile()?->getCustomerPaymentProfileId();
    }

    public function toTransactionDto(
        string $amount,
        PaymentMethod $paymentMethod,
        PaymentAccount $paymentAccount,
    ): TransactionDto
    {
        return TransactionDto::from([
            'id' => $this->id(),
            'amount' => $amount,
            'paymentMethod' => $paymentMethod,
            'paymentAccount' => $paymentAccount,
            'cardNumber' => $this->creditCardNumber(),
            'cardExpiration' => $this->creditCardExpiration(),
//            'paymentProfile' => $this->paymentProfileId(),
        ]);
    }
}
