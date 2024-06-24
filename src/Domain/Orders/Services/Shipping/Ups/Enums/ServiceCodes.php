<?php

namespace Domain\Orders\Services\Shipping\Ups\Enums;

enum ServiceCodes: string
{
    case NextDayAir = "01";
    case SecondDayAir = "02";
    case Ground = "03";
    case WorldwideExpress = "07";
    case WorldwideExpedited = "08";
    case Standard = "11";
    case ThreeDaySelect = "12";
    case NextDayAirSaver = "13";
    case NextDayAirEarlyAM = "14";
    case WorldwideExpressPlus = "54";
    case SecondDayAirAM = "59";
    case Saver = "65";
    case AccessPointEconomy = "70";
    case WorldwideExpressFreight = "96";
    case WorldwideExpressFreightMidday = "71";
    case WorldwideEconomyDdu = "17";
    case WorldwideExpeditedDdp = "72";

    public function label(Regions $from, Regions $to): string
    {
        return __("UPS ".$this->determineLabel($from, $to));
    }

    public function defaultLabels(): string
    {
        return match ($this) {
            self::NextDayAir => 'Next Day Air',
            self::WorldwideExpress => 'Worldwide Express',
            self::WorldwideExpedited => 'Worldwide Expedited',
            self::Standard => 'Standard',
            self::ThreeDaySelect => '3 Day Select',
            self::NextDayAirSaver => 'Next Day Air Saver',
            self::SecondDayAirAM => 'Second Day Air AM',
            self::Saver => 'Worldwide Saver',
            self::NextDayAirEarlyAM => 'Next Day Air Early AM',
            self::AccessPointEconomy => 'Access Point Economy',
            self::WorldwideExpressPlus => 'Worldwide Express Plus',
            self::SecondDayAir => 'Second Day Air',
            self::Ground => 'Ground',
            self::WorldwideExpressFreight => 'Worldwide Express Freight',
            self::WorldwideExpressFreightMidday => 'Worldwide Express Freight Midday',
            self::WorldwideEconomyDdu => 'Worldwide Economy DDU',
            self::WorldwideExpeditedDdp => 'Worldwide Expedited DDP',
        };
    }

    public function euLabels(): string
    {
        return match ($this) {
            self::WorldwideExpress => 'Express',
            self::WorldwideExpedited => 'Expedited',
            self::Saver => 'Worldwide Saver',
            default => $this->defaultLabels(),
        };
    }

    /**
     * @param Regions $from
     * @param Regions $to
     * @return string
     */
    private function determineLabel(Regions $from, Regions $to): string
    {
        if ($from != $to) {
            //international
            return match ($from) {
                Regions::EuropeanUnion => $this->euLabels(),
                Regions::Canada => match ($this) {
                    self::Saver => 'Express Saver',
                    default => $this->defaultLabels(),
                },
                default => $this->defaultLabels(),
            };
        }

        return match ($from) {
            Regions::EuropeanUnion => $this->euLabels(),
            Regions::Canada => match ($this) {
                self::NextDayAir => 'Express',
                self::NextDayAirSaver,
                self::Saver => 'Express Saver',
                self::WorldwideExpressPlus,
                self::NextDayAirEarlyAM => 'Express Early',
                default => $this->defaultLabels(),
            },
            default => $this->defaultLabels(),
        };
    }
}
