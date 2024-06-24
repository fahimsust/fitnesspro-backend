<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum PaymentIntents: string
{
    case Capture = 'CAPTURE';
    case Authorize = 'AUTHORIZE';
}
