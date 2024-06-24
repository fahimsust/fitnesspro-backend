<?php

namespace Domain\Orders\Enums\Cart;

enum CartItemRelations: string
{
    public const PRODUCT = 'product';
    public const OPTIONS_VALUES = 'optionValues';
    public const CUSTOM_FIELDS = 'customFields';
    public const ACCESSORY_FIELD = 'accessoryField';
    public const DISTRIBUTOR = 'distributor';
    public const PARENT_PRODUCT = 'parentProduct';
    public const REGISTRY_ITEM = 'registryItem';
    public const PARENT_ITEM = 'parentItem';
    public const REQUIRED_FOR = 'requiredFor';
    public const ACCESSORY_LINKED_ITEMS = 'accessoryLinkedActionItems';
    public const DISCOUNT_ADVANTAGES = 'discountAdvantages';
    public const DISCOUNT_CONDITIONS = 'discountConditions';

    public static function standard(): array
    {
        return [
            self::PRODUCT,
            self::OPTIONS_VALUES,
            self::CUSTOM_FIELDS,
            self::DISTRIBUTOR,
            self::ACCESSORY_LINKED_ITEMS,
            self::DISCOUNT_ADVANTAGES,
        ];
    }

    public static function all(): array
    {
        return array_map(fn ($case) => $case, self::cases());
    }
}
