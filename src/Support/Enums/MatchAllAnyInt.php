<?php

namespace Support\Enums;

enum MatchAllAnyInt: int
{
    case ALL = 0;
    case ANY = 1;

    public function isAny(): bool
    {
        return $this == self::ANY;
    }

    public function isAll(): bool
    {
        return $this == self::ALL;
    }
}
