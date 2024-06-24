<?php

namespace Support\Helpers;

class Math
{
    public static function formatPrice($price, $dec = '.', $sep = '')
    {
        return number_format(
            (float)$price,
            config('site.currency_decimal'),
            $dec,
            $sep
        );
    }

    public static function formatNumber($number, $places = 2, $dec = '.', $sep = '')
    {
        return number_format((float)$number, $places, $dec, $sep);
    }

    public static function round_up($value, $places = 0)
    {
        if ($places < 0) {
            $places = 0;
        }
        $mult = pow(10, $places);

        return ceil($value * $mult) / $mult;
    }

    public function convertDecimal($int)
    {
        if (strlen($int) === 1) {
            $int = '0.0' . $int;
        } elseif (strlen($int) === 2) {
            $int = '0.' . $int;
        } elseif (strlen($int) >= 3) {
            $int = substr($int, 0, -2) . '.' . substr($int, -2, 2);
        }

        return $int;
    }

    public static function ordinal($number)
    {
        if ($number % 100 > 10 && $number % 100 < 14)
            return 'th';

        return match ($number % 10) {
            0 => 'th',
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th',
        };
    }
}
