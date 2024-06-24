<?php

namespace Domain\Discounts\Enums;

enum DiscountRelations: string
{
    public const ACCOUNT_USES = 'accountUses';
    public const USED_BY_ACCOUNTS = 'usedByAccounts';
    public const ADVANTAGES = 'advantages';
    public const RULES = 'rules';
    public const CONDITIONS = self::RULES . '.conditions';
}
