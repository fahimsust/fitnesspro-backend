<?php

namespace Domain\Orders\Services\Shipping\Ups\Enums;

enum Regions: string
{
    case Canada = "CA";
    case UnitedStates = "US";
    case EuropeanUnion = "EU";
    case Mexico = "MX";
    case Poland = "PL";
    case PuertoRico = "PR";
    case Germany = "DE";
    case Other = "Other";

    public static function fromCountry(string $countryAbbreviation): static
    {
        if(in_array($countryAbbreviation, self::euCountries())) {
            return self::EuropeanUnion;
        }

        return match ($countryAbbreviation) {
            'CA' => self::Canada,
            'US' => self::UnitedStates,
            'MX' => self::Mexico,
            'PL' => self::Poland,
            'PR' => self::PuertoRico,
            'DE' => self::Germany,
            default => self::Other,
        };
    }

    public static function euCountries(): array
    {
        return [
            'BE', 'BG', 'CZ', 'DK',
            'EE', 'IE',
            'EL', 'ES', 'FR', 'HR',
            'IT', 'CY', 'LV', 'LT',
            'LU', 'HU', 'MT', 'NL',
            'AT', 'PT', 'RO',
            'SI', 'SK', 'FI', 'SE',
        ];
    }
}
