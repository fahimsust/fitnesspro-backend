<?php

namespace Domain\Products\Enums\BulkEdit;

use Domain\Products\Actions\BulkEdit\Perform\AssignAttribute;
use Domain\Products\Actions\BulkEdit\Perform\AssignDistributor;
use Domain\Products\Actions\BulkEdit\Perform\ReplaceProductFieldSubtextWithText;
use Domain\Products\Actions\BulkEdit\Perform\SetAvailability;
use Domain\Products\Actions\BulkEdit\Perform\SetDetailTemplate;
use Domain\Products\Actions\BulkEdit\Perform\SetDiscountLevel;
use Domain\Products\Actions\BulkEdit\Perform\SetDistributorStock;
use Domain\Products\Actions\BulkEdit\Perform\SetInventoried;
use Domain\Products\Actions\BulkEdit\Perform\SetNotInventoried;
use Domain\Products\Actions\BulkEdit\Perform\SetOrderingRule;
use Domain\Products\Actions\BulkEdit\Perform\SetPublishedOnSite;
use Domain\Products\Actions\BulkEdit\Perform\SetStatus;
use Domain\Products\Actions\BulkEdit\Perform\SetThumbnailTemplate;
use Domain\Products\Actions\BulkEdit\Perform\SetUnPublishedOnSite;
use Domain\Products\Actions\BulkEdit\Perform\SetZoomTemplate;
use Domain\Products\Actions\BulkEdit\Perform\UnAssignAttribute;
use Domain\Products\Actions\BulkEdit\Perform\UnSetDiscountLevel;
use Domain\Products\Actions\BulkEdit\Perform\UpdateBrand;
use Domain\Products\Actions\BulkEdit\Perform\UpdateDefaultCategory;
use Domain\Products\Actions\BulkEdit\Perform\UpdatePrice;
use Domain\Products\Actions\BulkEdit\Perform\UpdateProductType;
use Domain\Products\Actions\BulkEdit\Perform\UpdateWeight;

enum ActionList: string
{
    case REPLACE_SUBTEXT_WITH_TEXT = 'replace_subtext';
    case SET_PRICING = 'set_pricing';
    case SET_STATUS = 'set_status';
    case SET_OUT_OF_STOCK_STATUS = 'set_out_of_stock_status';
    case ASSIGN_BRAND = 'assign_brand';
    case ASSIGN_PRODUCT_TYPE = 'assign_product_type';
    case ASSIGN_ATTRIBUTES = 'assign_attributes';
    case UNASSIGN_ATTRIBUTES = 'unassign_attributes';
    case ASSIGN_DISTRIBUTOR = 'assign_distributor';
    case PUBLISH_ON_SITE = 'publish_on_site';
    case UNPUBLISH_ON_SITE = 'unpublish_on_site';
    case ASSIGN_DEFAULT_CATEGORY = 'assign_default_category';
    case SET_WEIGHT = 'set_weight';
    case SET_THUMBNAIL_TEMPLATE = 'set_thumbnail_template';
    case SET_DETAIL_TEMPLATE = 'set_detail_template';
    case SET_ZOOM_TEMPLATE = 'set_zoom_template';
    case SET_INVENTORIED = 'set_inventoried';
    case SET_NOT_INVENTORIED = 'set_not_inventoried';
    case SET_ORDERING_RULE = 'set_ordering_rule';
    case ASSIGN_TO_DISCOUNT_LEVEL = 'assign_to_discount_level';
    case UNASSIGN_FROM_DISCOUNT_LEVEL = 'unassign_from_discount_level';
    case MODIFY_DISTRIBUTOR_STOCK_QTY = 'modify_Distributor_stock_qty';

    public static function options(): array
    {
        return [
            [
                'id' => self::REPLACE_SUBTEXT_WITH_TEXT,
                'name' => __('replace subtext with text'),
                'component_type'=>'Subtext',
            ],
            [
                'id' => self::SET_PRICING,
                'name' => __('set pricing'),
                'component_type'=>'Pricing',
            ],
            [
                'id' => self::SET_STATUS,
                'name' => __('set status'),
                'component_type'=>'SetStatus',
            ],
            [
                'id' => self::SET_OUT_OF_STOCK_STATUS,
                'name' => __('set out of stock status'),
                'component_type'=>'SetOutOfStockStatus',
            ],
            [
                'id' => self::ASSIGN_BRAND,
                'name' => __('assign brand'),
                'component_type'=>'AssignBrand',
            ],
            [
                'id' => self::ASSIGN_PRODUCT_TYPE,
                'name' => __('assign product type'),
                'component_type'=>'AssignProductType',
            ],
            [
                'id' => self::ASSIGN_ATTRIBUTES,
                'name' => __('assign attribute(s)'),
                'component_type'=>'AssignAttribute',
            ],
            [
                'id' => self::UNASSIGN_ATTRIBUTES,
                'name' => __('unassign attribute(s)'),
                'component_type'=>'AssignAttribute',
            ],
            [
                'id' => self::ASSIGN_DISTRIBUTOR,
                'name' => __('assign distributor'),
                'component_type'=>'AssignDistributor',
            ],
            [
                'id' => self::PUBLISH_ON_SITE,
                'name' => __('published on site'),
                'component_type'=>'Site',
            ],
            [
                'id' => self::UNPUBLISH_ON_SITE,
                'name' => __('unpublished on site'),
                'component_type'=>'Site',
            ],
            [
                'id' => self::ASSIGN_DEFAULT_CATEGORY,
                'name' => __('assign default category'),
                'component_type'=>'DefaultCategory',
            ],
            [
                'id' => self::SET_WEIGHT,
                'name' => __('set weight'),
                'component_type'=>'Weight',
            ],
            [
                'id' => self::SET_THUMBNAIL_TEMPLATE,
                'name' => __('set thumbnail template'),
                'component_type'=>'ThumbnailTemplate',
            ],
            [
                'id' => self::SET_DETAIL_TEMPLATE,
                'name' => __('set detail template'),
                'component_type'=>'DetailTemplate',
            ],
            [
                'id' => self::SET_ZOOM_TEMPLATE,
                'name' => __('set zoom template'),
                'component_type'=>'ZoomTemplate',
            ],
            [
                'id' => self::SET_INVENTORIED,
                'name' => __('set inventoried'),
                'component_type'=>'EmptyWidget',
            ],
            [
                'id' => self::SET_NOT_INVENTORIED,
                'name' => __('set not inventoried'),
                'component_type'=>'EmptyWidget',
            ],
            [
                'id' => self::SET_ORDERING_RULE,
                'name' => __('set ordering rule'),
                'component_type'=>'OrderingRule',
            ],
            [
                'id' => self::ASSIGN_TO_DISCOUNT_LEVEL,
                'name' => __('assign to disocunt level'),
                'component_type'=>'DisocuntLevel',
            ],
            [
                'id' => self::UNASSIGN_FROM_DISCOUNT_LEVEL,
                'name' => __('unassign from disocunt level'),
                'component_type'=>'DisocuntLevel',
            ],
            [
                'id' => self::MODIFY_DISTRIBUTOR_STOCK_QTY,
                'name' => __('modify distributor stock qty'),
                'component_type'=>'DistributorStockQty',
            ],
        ];
    }
    public static function getByValue($value)
    {
        return match ($value) {
            self::REPLACE_SUBTEXT_WITH_TEXT->value => self::REPLACE_SUBTEXT_WITH_TEXT,
            self::SET_PRICING->value => self::SET_PRICING,
            self::SET_STATUS->value => self::SET_STATUS,
            self::SET_OUT_OF_STOCK_STATUS->value => self::SET_OUT_OF_STOCK_STATUS,
            self::ASSIGN_BRAND->value => self::ASSIGN_BRAND,
            self::ASSIGN_PRODUCT_TYPE->value => self::ASSIGN_PRODUCT_TYPE,
            self::ASSIGN_ATTRIBUTES->value => self::ASSIGN_ATTRIBUTES,
            self::UNASSIGN_ATTRIBUTES->value => self::UNASSIGN_ATTRIBUTES,
            self::ASSIGN_DISTRIBUTOR->value => self::ASSIGN_DISTRIBUTOR,
            self::PUBLISH_ON_SITE->value => self::PUBLISH_ON_SITE,
            self::UNPUBLISH_ON_SITE->value => self::UNPUBLISH_ON_SITE,
            self::ASSIGN_DEFAULT_CATEGORY->value => self::ASSIGN_DEFAULT_CATEGORY,
            self::SET_WEIGHT->value => self::SET_WEIGHT,
            self::SET_THUMBNAIL_TEMPLATE->value => self::SET_THUMBNAIL_TEMPLATE,
            self::SET_DETAIL_TEMPLATE->value => self::SET_DETAIL_TEMPLATE,
            self::SET_ZOOM_TEMPLATE->value => self::SET_ZOOM_TEMPLATE,
            self::SET_INVENTORIED->value => self::SET_INVENTORIED,
            self::SET_NOT_INVENTORIED->value => self::SET_NOT_INVENTORIED,
            self::SET_ORDERING_RULE->value => self::SET_ORDERING_RULE,
            self::ASSIGN_TO_DISCOUNT_LEVEL->value => self::ASSIGN_TO_DISCOUNT_LEVEL,
            self::UNASSIGN_FROM_DISCOUNT_LEVEL->value => self::UNASSIGN_FROM_DISCOUNT_LEVEL,
            self::MODIFY_DISTRIBUTOR_STOCK_QTY->value => self::MODIFY_DISTRIBUTOR_STOCK_QTY,
        };
    }
    public function action()
    {
        return match ($this) {
            self::REPLACE_SUBTEXT_WITH_TEXT => ReplaceProductFieldSubtextWithText::class,
            self::SET_PRICING => UpdatePrice::class,
            self::SET_STATUS => SetStatus::class,
            self::SET_OUT_OF_STOCK_STATUS => SetAvailability::class,
            self::ASSIGN_BRAND => UpdateBrand::class,
            self::ASSIGN_PRODUCT_TYPE => UpdateProductType::class,
            self::ASSIGN_ATTRIBUTES => AssignAttribute::class,
            self::UNASSIGN_ATTRIBUTES => UnAssignAttribute::class,
            self::ASSIGN_DISTRIBUTOR => AssignDistributor::class,
            self::PUBLISH_ON_SITE => SetPublishedOnSite::class,
            self::UNPUBLISH_ON_SITE => SetUnPublishedOnSite::class,
            self::ASSIGN_DEFAULT_CATEGORY => UpdateDefaultCategory::class,
            self::SET_WEIGHT => UpdateWeight::class,
            self::SET_THUMBNAIL_TEMPLATE => SetThumbnailTemplate::class,
            self::SET_DETAIL_TEMPLATE => SetDetailTemplate::class,
            self::SET_ZOOM_TEMPLATE => SetZoomTemplate::class,
            self::SET_INVENTORIED => SetInventoried::class,
            self::SET_NOT_INVENTORIED => SetNotInventoried::class,
            self::SET_ORDERING_RULE => SetOrderingRule::class,
            self::ASSIGN_TO_DISCOUNT_LEVEL => SetDiscountLevel::class,
            self::UNASSIGN_FROM_DISCOUNT_LEVEL => UnSetDiscountLevel::class,
            self::MODIFY_DISTRIBUTOR_STOCK_QTY => SetDistributorStock::class,
        };
    }
}
