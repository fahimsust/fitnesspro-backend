<?php

namespace Domain\Accounts\Enums;

enum AccountStatus: int
{
    case REGISTERING = 7;
    case ACTIVE = 1;
    case INACTIVE = 2;
    case AWAITING_APPROVAL = 3;
    case AWAITING_SUBSCRIPTION_PAYMENT = 4;
    case DELETED = 5;
    case AWAITING_EMAIL_VERIFICATION = 6;
}
