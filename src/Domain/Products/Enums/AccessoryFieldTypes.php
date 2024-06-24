<?php

namespace Domain\Products\Enums;

enum AccessoryFieldTypes: int
{
    case SELECT = 1;
    case RADIO = 2;
    case CHECKBOXES = 3;
}
