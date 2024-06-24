<?php

namespace Domain\Discounts\Enums;

enum DiscountAdvantageTypes: int
{
    case FREE_SHIPPING = 1;
    case PERCENTAGE_OFF_SHIPPING = 2;
    case AMOUNT_OFF_SHIPPING = 3;
    case FREE_PRODUCT = 4;
    case PERCENTAGE_OFF_PRODUCT = 5;
    case AMOUNT_OFF_PRODUCT = 6;
    case PERCENTAGE_OFF_ORDER = 7;
    case AMOUNT_OFF_ORDER = 8;
    case FREE_PRODUCT_AUTO_ADDED = 9;
    case FREE_PRODUCT_OF_TYPE = 10;
    case PERCENTAGE_OFF_PRODUCT_OF_TYPE = 11;
    case AMOUNT_OFF_PRODUCT_OF_TYPE = 12;
    case PERCENTAGE_OFF_PRODUCT_AUTO_ADDED = 13;
    case AMOUNT_OFF_PRODUCT_AUTO_ADDED = 14;

    public static function options(): array
    {
        return [
            [
                'id' => self::FREE_SHIPPING,
                'name' => self::FREE_SHIPPING->label(),
                'component_type' => 'FreeShipping'
            ],
            [
                'id' => self::PERCENTAGE_OFF_SHIPPING,
                'name' => self::PERCENTAGE_OFF_SHIPPING->label(),
                'component_type' => 'PercentageOfShipping'
            ],
            [
                'id' => self::AMOUNT_OFF_SHIPPING,
                'name' => self::AMOUNT_OFF_SHIPPING->label(),
                'component_type' => 'AmountOfShipping'
            ],
            [
                'id' => self::FREE_PRODUCT,
                'name' => self::FREE_PRODUCT->label(),
                'component_type' => 'FreeProduct'
            ],
            [
                'id' => self::PERCENTAGE_OFF_PRODUCT,
                'name' => self::PERCENTAGE_OFF_PRODUCT->label(),
                'component_type' => 'PercentageOffProduct'
            ],
            [
                'id' => self::AMOUNT_OFF_PRODUCT,
                'name' => self::AMOUNT_OFF_PRODUCT->label(),
                'component_type' => 'AmountOffProduct'
            ],
            [
                'id' => self::PERCENTAGE_OFF_ORDER,
                'name' => self::PERCENTAGE_OFF_ORDER->label(),
                'component_type' => 'PercentageOffOrder'
            ],
            [
                'id' => self::AMOUNT_OFF_ORDER,
                'name' => self::AMOUNT_OFF_ORDER->label(),
                'component_type' => 'AmountOffOrder'
            ],
            [
                'id' => self::FREE_PRODUCT_AUTO_ADDED,
                'name' => self::FREE_PRODUCT_AUTO_ADDED->label(),
                'component_type' => 'FreeProductAutoAdded'
            ],
            [
                'id' => self::FREE_PRODUCT_OF_TYPE,
                'name' => self::FREE_PRODUCT_OF_TYPE->label(),
                'component_type' => 'FreeProductOfType'
            ],
            [
                'id' => self::PERCENTAGE_OFF_PRODUCT_OF_TYPE,
                'name' => self::PERCENTAGE_OFF_PRODUCT_OF_TYPE->label(),
                'component_type' => 'PercentageOffProductOfType'
            ],
            [
                'id' => self::AMOUNT_OFF_PRODUCT_OF_TYPE,
                'name' => self::AMOUNT_OFF_PRODUCT_OF_TYPE->label(),
                'component_type' => 'AmountOffProductOfType'
            ],
            [
                'id' => self::PERCENTAGE_OFF_PRODUCT_AUTO_ADDED,
                'name' => self::PERCENTAGE_OFF_PRODUCT_AUTO_ADDED->label(),
                'component_type' => 'PercentageOffProductAutoAdded'
            ],
            [
                'id' => self::AMOUNT_OFF_PRODUCT_AUTO_ADDED,
                'name' => self::AMOUNT_OFF_PRODUCT_AUTO_ADDED->label(),
                'component_type' => 'AmountOffProductAutoAdded'
            ]
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::FREE_SHIPPING => __('Free Shipping'),
            self::PERCENTAGE_OFF_SHIPPING => __('Percentage Off Shipping'),
            self::AMOUNT_OFF_SHIPPING => __('Amount Off Shipping'),
            self::FREE_PRODUCT => __('Free Product (Not Auto Added)'),
            self::PERCENTAGE_OFF_PRODUCT => __('Percentage Off Product'),
            self::AMOUNT_OFF_PRODUCT => __('Amount Off Product'),
            self::PERCENTAGE_OFF_ORDER => __('Percentage Off Order'),
            self::AMOUNT_OFF_ORDER => __('Amount Off Order'),
            self::FREE_PRODUCT_AUTO_ADDED => __('Free Product (Auto Added to Cart)'),
            self::FREE_PRODUCT_OF_TYPE => __('Free Product of Specified Type (Not Auto Added)'),
            self::PERCENTAGE_OFF_PRODUCT_OF_TYPE => __('Percentage Off Product of Specified Type'),
            self::AMOUNT_OFF_PRODUCT_OF_TYPE => __('Amount Off Product of Specified Type'),
            self::PERCENTAGE_OFF_PRODUCT_AUTO_ADDED => __('Percentage Off Product (Auto Added to Cart)'),
            self::AMOUNT_OFF_PRODUCT_AUTO_ADDED => __('Amount Off Product (Auto Added to Cart)'),
        };
    }

    public function amount(float $amount): string
    {
        return match ($this) {
            self::FREE_SHIPPING,
            self::FREE_PRODUCT_OF_TYPE,
            self::FREE_PRODUCT,
            self::FREE_PRODUCT_AUTO_ADDED => __('Free'),

            self::PERCENTAGE_OFF_PRODUCT,
            self::PERCENTAGE_OFF_PRODUCT_AUTO_ADDED,
            self::PERCENTAGE_OFF_PRODUCT_OF_TYPE,
            self::PERCENTAGE_OFF_ORDER,
            self::PERCENTAGE_OFF_SHIPPING => __("%{$amount}"),

            default => $amount,
        };
    }

    public static function orderAdvantages(): array
    {
        return [
            self::PERCENTAGE_OFF_ORDER,
            self::AMOUNT_OFF_ORDER,
        ];
    }

    public function isOrderAdvantage(): bool
    {
        return in_array($this, self::orderAdvantages());
    }

    public static function shippingAdvantages(): array
    {
        return [
            self::FREE_SHIPPING,
            self::PERCENTAGE_OFF_SHIPPING,
            self::AMOUNT_OFF_SHIPPING,
        ];
    }

    public function isShippingAdvantage(): bool
    {
        return in_array($this, self::shippingAdvantages());
    }

    public static function productSpecificAdvantages(): array
    {
        return [
            self::FREE_PRODUCT,
            self::PERCENTAGE_OFF_PRODUCT,
            self::AMOUNT_OFF_PRODUCT,
            self::FREE_PRODUCT_AUTO_ADDED,
            self::PERCENTAGE_OFF_PRODUCT_AUTO_ADDED,
            self::AMOUNT_OFF_PRODUCT_AUTO_ADDED,
        ];
    }

    public function isProductSpecific(): bool
    {
        return in_array($this, self::productSpecificAdvantages());
    }

    public static function productTypeSpecificAdvantages(): array
    {
        return [
            self::FREE_PRODUCT_OF_TYPE,
            self::PERCENTAGE_OFF_PRODUCT_OF_TYPE,
            self::AMOUNT_OFF_PRODUCT_OF_TYPE,
        ];
    }

    public function isProductTypeSpecific(): bool
    {
        return in_array($this, self::productTypeSpecificAdvantages());
    }

    public static function autoAddAdvantages(): array
    {
        return [
            self::FREE_PRODUCT_AUTO_ADDED,
            self::PERCENTAGE_OFF_PRODUCT_AUTO_ADDED,
            self::AMOUNT_OFF_PRODUCT_AUTO_ADDED,
        ];
    }

    public function isAutoAdd(): bool
    {
        return in_array($this, self::autoAddAdvantages());
    }

    public function isProductAdvantage(): bool
    {
        return $this->isProductTypeSpecific()
            || $this->isProductSpecific();
    }
}
