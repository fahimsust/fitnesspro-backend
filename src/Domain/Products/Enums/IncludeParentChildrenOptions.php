<?php

namespace Domain\Products\Enums;

enum IncludeParentChildrenOptions: int
{
    case ParentsOnly = 0;
    case ChildrenOnly = 1;
    case Both = 2;

    public function parentsOnly(): bool
    {
        return $this === self::ParentsOnly;
    }

    public function childrenOnly(): bool
    {
        return $this === self::ChildrenOnly;
    }

    public function includesChildren(): bool
    {
        return $this === self::ChildrenOnly
            || $this === self::Both;
    }

    public function both(): bool
    {
        return $this === self::Both;
    }
}
