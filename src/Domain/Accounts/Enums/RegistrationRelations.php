<?php

namespace Domain\Accounts\Enums;

enum RegistrationRelations: string
{
    case Account = 'account';
    case Affiliate = 'affiliate';
    case Level = 'level';
    case LevelWithProduct = 'levelWithProduct';
    case Site = 'site';
//    case Discounts = 'discounts';
    case PaymentMethod = 'paymentMethod';
    case Cart = 'cart';
}
