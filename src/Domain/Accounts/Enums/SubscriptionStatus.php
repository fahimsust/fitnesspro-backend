<?php

namespace Domain\Accounts\Enums;

enum SubscriptionStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;//cancelled or expired
}
