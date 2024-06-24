<?php

namespace Domain\Payments\Services\AuthorizeNet\ValueObjects;

use net\authorize\api\contract\v1\CustomerProfilePaymentType;
use net\authorize\api\contract\v1\PaymentProfileType;

class CustomerPaymentProfileVO
{
    public function __construct(
        public string                   $profileId,
        public string                   $paymentProfileId,
    )
    {
    }

    public function getCustomerProfilePaymentType(): CustomerProfilePaymentType
    {
        return (new CustomerProfilePaymentType)
            ->setCustomerProfileId($this->profileId)
            ->setPaymentProfile(
                (new PaymentProfileType())
                    ->setPaymentProfileId($this->paymentProfileId)
            );
    }
}
