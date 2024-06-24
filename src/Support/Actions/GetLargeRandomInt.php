<?php

namespace Support\Actions;

use Lorisleiva\Actions\Concerns\AsObject;

class GetLargeRandomInt
{
    use AsObject;

    public function handle(): int
    {
        return random_int(1000000, 9999999);
    }
}
