<?php

namespace Domain\Products\Enums;

enum FilterFieldTypes: int
{
    case Select = 0;
    case Checkboxes = 1;
}
