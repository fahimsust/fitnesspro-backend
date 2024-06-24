<?php

namespace Support\Services\DigitalOcean;

use Illuminate\Support\Facades\Storage;

class Spaces
{
    public static function resolve()
    {
        return resolve(static::class);
    }

    public function push($file, $stream)
    {
        return Storage::disk('spaces')
            ->put($file, $stream, 'public');
    }
}
