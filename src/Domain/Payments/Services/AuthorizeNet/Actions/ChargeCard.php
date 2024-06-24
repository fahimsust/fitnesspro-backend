<?php

namespace Domain\Payments\Services\AuthorizeNet\Actions;

use Domain\Payments\Services\AuthorizeNet\ValueObjects\ChargeRequestVO;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\PaymentType;

class ChargeCard extends AbstractChargeAction
{
    public PaymentType $paymentType;

    public function __construct(
        public ChargeRequestVO $chargeRequest,
        public CreditCardType  $card,
    )
    {
        $this->initTransactionRequest();

        $this->paymentType = (new PaymentType)
            ->setCreditCard($this->card);
    }

    public function execute(): static
    {
        $this->chargeRequest->request->setTransactionRequest(
            $this->transactionRequest
                ->setAmount($this->chargeRequest->amount)
                ->setPayment($this->paymentType)
        );

        $this->executeAndHandleResponse();

        return $this;
    }
}
