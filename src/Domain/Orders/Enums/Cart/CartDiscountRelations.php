<?php

namespace Domain\Orders\Enums\Cart;

enum CartDiscountRelations: string
{
    case ADVANTAGES = 'advantages';
    case CODES = 'codes';

    public static function all(): array
    {
        return [
            self::ADVANTAGES->value,
            self::CODES->value,
        ];
    }
}
