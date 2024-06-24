<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum PaymentInitiators: string
{
    case Customer = 'CUSTOMER';
    case Merchant = 'MERCHANT';
}
