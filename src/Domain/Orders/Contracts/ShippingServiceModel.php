<?php

namespace Domain\Orders\Contracts;

interface ShippingServiceModel
{
    public static function config(): array;

    public static function credentials(): array;
}
