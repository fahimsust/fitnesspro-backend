<?php

namespace Domain\Payments\Services\AuthorizeNet\ValueObjects;

use Illuminate\Support\Carbon;
use net\authorize\api\contract\v1\CreditCardType;

class CreditCardVO
{
    public function __construct(
        public string $number,
        public Carbon $expiration,
        public string $code
    )
    {
    }

    public function getCreditCardType(): CreditCardType
    {
        return (new CreditCardType)
            ->setCardNumber($this->number)
            ->setExpirationDate($this->expiration->format("Y-m"))
            ->setCardCode($this->code);
    }
}
