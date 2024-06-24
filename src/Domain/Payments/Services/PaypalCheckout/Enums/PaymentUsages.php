<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum PaymentUsages: string
{
    case First = 'FIRST';
    case Subsequent = 'SUBSEQUENT';
    case Derived = 'DERIVED';
}
