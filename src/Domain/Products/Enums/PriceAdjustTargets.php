<?php

namespace Domain\Products\Enums;

enum PriceAdjustTargets: int
{
    case THIS_ITEM = 1;
    case PARENT_ITEM = 2;
}
