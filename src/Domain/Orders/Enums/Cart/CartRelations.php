<?php

namespace Domain\Orders\Enums\Cart;

enum CartRelations: string
{
    public const ITEMS = 'items';
    public const CART_DISCOUNTS = 'cartDiscounts';
    public const DISCOUNTS = 'discounts';
    public const DISCOUNT_CODES = 'discountCodes';

    public static function standard(string|array|null $append = null): array
    {
        $base = [
            self::ITEMS => CartItemRelations::standard(),
            self::CART_DISCOUNTS => CartDiscountRelations::all(),
        ];

        if ($append) {
            $base = array_merge(
                $base,
                is_string($append) ? [$append] : $append
            );
        }

        return $base;
    }
}
