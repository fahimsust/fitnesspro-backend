<?php

namespace Domain\Products\Enums\Category;

enum CategoryStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
}
