<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum PaymentTypes: string
{
    case OneTime = 'ONE_TIME';
    case Recurring = 'RECURRING';
    case Unscheduled = 'UNSCHEDULED';
}
