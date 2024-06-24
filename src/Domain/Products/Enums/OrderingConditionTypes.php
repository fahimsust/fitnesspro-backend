<?php

namespace Domain\Products\Enums;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Specialty;
use Domain\Products\Actions\OrderingRules\OrderingConditions\CheckRequiredAccountType;
use Domain\Products\Actions\OrderingRules\OrderingConditions\CheckRequiredSpecialty;

enum OrderingConditionTypes: string
{
    case REQUIRED_SPECIALTY = 'required_account_specialty';
    case REQUIRED_ACCOUNT_TYPE = 'required_account_type';

    public function label(): string
    {
        return match ($this) {
            self::REQUIRED_SPECIALTY => __('Required Specialty'),
            self::REQUIRED_ACCOUNT_TYPE => __('Required Account Type'),
        };
    }

    public function action()
    {
        return match ($this) {
            self::REQUIRED_SPECIALTY => CheckRequiredSpecialty::class,
            self::REQUIRED_ACCOUNT_TYPE => CheckRequiredAccountType::class,
        };
    }
    public function className()
    {
        return match ($this) {
            self::REQUIRED_SPECIALTY => Specialty::class,
            self::REQUIRED_ACCOUNT_TYPE => AccountType::class,
        };
    }
}
