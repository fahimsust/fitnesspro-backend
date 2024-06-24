<?php

namespace Support\Dtos;

use Spatie\LaravelData\Data;

class RedirectUrl extends Data
{
    public function __construct(
        public string $url
    )
    {
    }
}
