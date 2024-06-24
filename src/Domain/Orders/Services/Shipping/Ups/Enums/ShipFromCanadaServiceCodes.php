<?php

namespace Domain\Orders\Services\Shipping\Ups\Enums;

enum ShipFromCanadaServiceCodes: string
{
    //canada service codes
    case Standard = "11";
    case WorldwideExpedited = "08";
    case WorldwideExpressPlus = "54";
    case Saver = "65";
    case Expedited = "02";
    case ExpressSaver = "13";
    case Express = "01";
    case ThreeDaySelect = "12";
    case ExpressEarly = "14";

    public function label()
    {
        return match ($this) {
            self::Standard => 'Standard',
            self::WorldwideExpedited => 'Worldwide Expedited',
            self::WorldwideExpress => 'Worldwide Express',
            self::WorldwideExpressPlus => 'Worldwide Express Plus',
            self::Saver => 'Express Saver',
            self::Expedited => 'Expedited',
            self::ExpressSaver => 'Express Saver',
            self::Express => 'Express',
            self::ThreeDaySelect => '3 Day Select',
            self::AccessPointEconomy => 'Access Point Economy',
            self::ExpressEarly => 'Express Early',
        };
    }
}
