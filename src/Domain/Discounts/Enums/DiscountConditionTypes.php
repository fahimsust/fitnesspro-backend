<?php

namespace Domain\Discounts\Enums;

use Domain\Discounts\Actions\DiscountConditions\CheckAccountTypeMatchesCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckActiveMembershipLevel;
use Domain\Discounts\Actions\DiscountConditions\CheckCartAmountMeetsMinRequired;
use Domain\Discounts\Actions\DiscountConditions\CheckDateRangeCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckDiscountCodeMatches;
use Domain\Discounts\Actions\DiscountConditions\CheckMembershipExpiresWithinRequiredDays;
use Domain\Discounts\Actions\DiscountConditions\CheckOnSaleStatusMatchesCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckOutOfStockStatusMatchesCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckProductAttributeMatchesCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckProductAvailabilityMatchesCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckProductTypeMatchesCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckRequiredProductInCart;
use Domain\Discounts\Actions\DiscountConditions\CheckSiteMatchesCondition;
use Domain\Discounts\Actions\DiscountConditions\CheckUserIsLoggedIn;

enum DiscountConditionTypes: int
{
    case MINIMUM_CART_AMOUNT = 1;
    case REQUIRED_PRODUCT = 2;
    case REQUIRED_DISCOUNT_CODE = 3;
    case REQUIRED_PRODUCT_TYPE = 4;
    case REQUIRED_ATTRIBUTE_OPTION = 5;
    case REQUIRED_ACCOUNT = 6;
    case REQUIRED_ACCOUNT_TYPE = 7;
    case OUT_OF_STOCK_STATUS = 8;
    case PRODUCT_AVAILABILITY = 9;
    case PRODUCT_SALE_STATUS = 10;
    case ACTIVE_MEMBERSHIP_LEVEL = 11;
    case MEMBERSHIP_EXPIRES_IN_DAYS = 12;
    case REQUIRED_SITE = 13;
    case DATE_RANGE = 14;

    public static function options(): array
    {
        return [
            [
                'id' => self::MINIMUM_CART_AMOUNT,
                'name' => self::MINIMUM_CART_AMOUNT->label(),
                'component_type' => 'MinCartAmount'
            ],
            [
                'id' => self::REQUIRED_PRODUCT,
                'name' => self::REQUIRED_PRODUCT->label(),
                'component_type' => 'RequiredProduct'
            ],
            [
                'id' => self::REQUIRED_DISCOUNT_CODE,
                'name' => self::REQUIRED_DISCOUNT_CODE->label(),
                'component_type' => 'RequiredDiscountCode'
            ],
            [
                'id' => self::REQUIRED_PRODUCT_TYPE,
                'name' => self::REQUIRED_PRODUCT_TYPE->label(),
                'component_type' => 'RequiredProductType'
            ],
            [
                'id' => self::REQUIRED_ATTRIBUTE_OPTION,
                'name' => self::REQUIRED_ATTRIBUTE_OPTION->label(),
                'component_type' => 'RequiredAttributeOption'
            ],
            [
                'id' => self::REQUIRED_ACCOUNT,
                'name' => self::REQUIRED_ACCOUNT->label(),
                'component_type' => 'RequiredAccount'
            ],
            [
                'id' => self::REQUIRED_ACCOUNT_TYPE,
                'name' => self::REQUIRED_ACCOUNT_TYPE->label(),
                'component_type' => 'RequiredAccountType'
            ],
            [
                'id' => self::OUT_OF_STOCK_STATUS,
                'name' => self::OUT_OF_STOCK_STATUS->label(),
                'component_type' => 'OutOfStockStatus'
            ],
            [
                'id' => self::PRODUCT_AVAILABILITY,
                'name' => self::PRODUCT_AVAILABILITY->label(),
                'component_type' => 'ProductAvailability'
            ],
            [
                'id' => self::PRODUCT_SALE_STATUS,
                'name' => self::PRODUCT_SALE_STATUS->label(),
                'component_type' => 'ProductSaleStatus'
            ],
            [
                'id' => self::ACTIVE_MEMBERSHIP_LEVEL,
                'name' => self::ACTIVE_MEMBERSHIP_LEVEL->label(),
                'component_type' => 'ActiveMembershipLevel'
            ],
            [
                'id' => self::MEMBERSHIP_EXPIRES_IN_DAYS,
                'name' => self::MEMBERSHIP_EXPIRES_IN_DAYS->label(),
                'component_type' => 'MembershipExpiresInDays'
            ],
            [
                'id' => self::REQUIRED_SITE,
                'name' => self::REQUIRED_SITE->label(),
                'component_type' => 'RequiredSite'
            ],
            [
                'id' => self::DATE_RANGE,
                'name' => self::DATE_RANGE->label(),
                'component_type' => 'DateRange'
            ],
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::MINIMUM_CART_AMOUNT => __('Minimum Cart Amount'),
            self::REQUIRED_PRODUCT => __('Required Product'),
            self::REQUIRED_DISCOUNT_CODE => __('Required Discount Code'),
            self::REQUIRED_PRODUCT_TYPE => __('Required Product Type'),
            self::REQUIRED_ATTRIBUTE_OPTION => __('Required Attribute Option'),
            self::REQUIRED_ACCOUNT => __('Required Account'),
            self::REQUIRED_ACCOUNT_TYPE => __('Required Account Type(s)'),
            self::OUT_OF_STOCK_STATUS => __('Required Out of Stock Status'),
            self::PRODUCT_AVAILABILITY => __('Required Product Availability'),
            self::PRODUCT_SALE_STATUS => __('Required Product On Sale Status'),
            self::ACTIVE_MEMBERSHIP_LEVEL => __('Required Active Membership Level'),
            self::MEMBERSHIP_EXPIRES_IN_DAYS => __('Membership Expires in # Days'),
            self::REQUIRED_SITE => __('Required Site'),
            self::DATE_RANGE => __('Date Range'),
        };
    }

    public function action()
    {
        return match ($this) {
            self::MINIMUM_CART_AMOUNT => CheckCartAmountMeetsMinRequired::class,
            self::REQUIRED_PRODUCT => CheckRequiredProductInCart::class,
            self::REQUIRED_DISCOUNT_CODE => CheckDiscountCodeMatches::class,
            self::REQUIRED_PRODUCT_TYPE => CheckProductTypeMatchesCondition::class,
            self::REQUIRED_ATTRIBUTE_OPTION => CheckProductAttributeMatchesCondition::class,
            self::REQUIRED_ACCOUNT => CheckUserIsLoggedIn::class,
            self::REQUIRED_ACCOUNT_TYPE => CheckAccountTypeMatchesCondition::class,
            self::OUT_OF_STOCK_STATUS => CheckOutOfStockStatusMatchesCondition::class,
            self::PRODUCT_AVAILABILITY => CheckProductAvailabilityMatchesCondition::class,
            self::PRODUCT_SALE_STATUS => CheckOnSaleStatusMatchesCondition::class,
            self::ACTIVE_MEMBERSHIP_LEVEL => CheckActiveMembershipLevel::class,
            self::MEMBERSHIP_EXPIRES_IN_DAYS => CheckMembershipExpiresWithinRequiredDays::class,
            self::REQUIRED_SITE => CheckSiteMatchesCondition::class,
            self::DATE_RANGE => CheckDateRangeCondition::class,
            //todo in future (maybe):
            //            14 => CheckShipCountry::class,
            //            15 => CheckDistributor::class
        };
    }
}
