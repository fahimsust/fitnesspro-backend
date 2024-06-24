<?php

namespace Domain\Orders\Services\Shipping\Ups\Enums;

enum RateTypes: string
{
    case Rate = 'Rate';
    case Shop = 'Shop';
}
