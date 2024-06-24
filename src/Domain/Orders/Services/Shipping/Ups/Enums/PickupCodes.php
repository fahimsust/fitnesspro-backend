<?php

namespace Domain\Orders\Services\Shipping\Ups\Enums;

enum PickupCodes: string
{
    case Daily = '01';
    case CustomerCounter = '03';
    case OneTimePickup = '06';
    case OnCallAir = '07';
    case LetterCenter = '19';
    case AirServiceCenter = '20';
}
