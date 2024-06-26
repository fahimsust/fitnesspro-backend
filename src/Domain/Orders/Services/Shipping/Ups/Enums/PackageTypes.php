<?php

namespace Domain\Orders\Services\Shipping\Ups\Enums;

enum PackageTypes: string
{
    case Unknown = '00';
    case UPSLetter = '01';
    case Package = '02';
    case Tube = '03';
    case Pak = '04';
    case ExpressBox = '21';
    case TwentyFiveKgBox = '24';
    case TenKgBox = '25';
    case Pallet = '30';
    case SmallExpressBox = '2a';
    case MediumExpressBox = '2b';
    case LargeExpressBox = '2c';
}
