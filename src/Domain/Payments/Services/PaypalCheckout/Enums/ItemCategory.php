<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum ItemCategory: string
{
    case DigitalGoods = 'DIGITAL_GOODS';
    case PhysicalGoods = 'PHYSICAL_GOODS';
    case Donation = 'DONATION';
}
