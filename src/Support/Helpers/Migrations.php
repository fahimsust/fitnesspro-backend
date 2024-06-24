<?php

namespace Support\Helpers;

class Migrations
{
    public static function isLocalOrTesting()
    {
        return in_array(config('app.env'), ['local', 'testing']);
    }
}
