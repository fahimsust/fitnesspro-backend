<?php

namespace Domain\Orders\Services\Shipping\Ups\Enums;

enum Modes: string
{
    case Test = "test";//'https://wwwcie.ups.com/ship/oauth2/access_token';
    case Live = "live";//'https://onlinetools.ups.com/ship/oauth2/access_token';

    public function url(): string
    {
        return match ($this) {
            self::Test => 'https://wwwcie.ups.com/',
            self::Live => 'https://onlinetools.ups.com/',
        };
    }
}
