<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum ShippingType: string
{
    case Shipping = 'SHIPPING';
    case Pickup = 'PICKUP_IN_PERSON';
}
