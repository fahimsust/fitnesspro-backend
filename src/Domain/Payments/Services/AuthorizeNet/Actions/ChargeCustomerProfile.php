<?php

namespace Domain\Payments\Services\AuthorizeNet\Actions;

use Domain\Payments\Services\AuthorizeNet\ValueObjects\ChargeRequestVO;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;

class ChargeCustomerProfile extends AbstractChargeAction
{
    public function __construct(
        public ChargeRequestVO            $chargeRequest,
        public CustomerProfilePaymentType $profile
    )
    {
        $this->initTransactionRequest();
    }

    public function execute(): static
    {
        $this->chargeRequest->request->setTransactionRequest(
            $this->transactionRequest
                ->setAmount($this->chargeRequest->amount)
                ->setProfile($this->profile)
        );

        $this->executeAndHandleResponse();

        return $this;
    }

//        echo " Transaction Response code : " . $transactionResponse->getResponseCode() . "\n";
//        echo  "Charge Customer Profile APPROVED  :" . "\n";
//        echo " Charge Customer Profile AUTH CODE : " . $transactionResponse->getAuthCode() . "\n";
//        echo " Charge Customer Profile TRANS ID  : " . $transactionResponse->getTransId() . "\n";
//        echo " Code : " . $transactionResponse->getMessages()[0]->getCode() . "\n";
//        echo " Description : " . $transactionResponse->getMessages()[0]->getDescription() . "\n";
}
