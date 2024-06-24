<?php

namespace Domain\Products\Enums\BulkEdit;

use Domain\Products\Actions\BulkEdit\Find\GetBrandNotMatched;
use Domain\Products\Actions\BulkEdit\Find\GetProductByAllAttribute;
use Domain\Products\Actions\BulkEdit\Find\GetProductByAnyAttribute;
use Domain\Products\Actions\BulkEdit\Find\GetProductByBrand;
use Domain\Products\Actions\BulkEdit\Find\GetProductByCombinedStockBetween;
use Domain\Products\Actions\BulkEdit\Find\GetProductByCombinedStockNotBetween;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDefaultCategory;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDefaultCategoryNot;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDefaultCostBetween;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDefaultCostNotBetween;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDefaultOutOfStatus;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDefaultOutOfStatusNot;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDetailsTemplate;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDisocuntLevel;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDistributor;
use Domain\Products\Actions\BulkEdit\Find\GetProductByDistributorNot;
use Domain\Products\Actions\BulkEdit\Find\GetProductByInventoried;
use Domain\Products\Actions\BulkEdit\Find\GetProductByIsChild;
use Domain\Products\Actions\BulkEdit\Find\GetProductByIsParent;
use Domain\Products\Actions\BulkEdit\Find\GetProductByKeywordExists;
use Domain\Products\Actions\BulkEdit\Find\GetProductByKeywordMatch;
use Domain\Products\Actions\BulkEdit\Find\GetProductByKeywordNotExists;
use Domain\Products\Actions\BulkEdit\Find\GetProductByKeywordNotMatch;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotDetailsTemplate;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotDisocuntLevel;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotHaveAllAttribute;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotHaveAnyAttribute;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotInventoried;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotPublishedOnSite;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotThumbnailTemplate;
use Domain\Products\Actions\BulkEdit\Find\GetProductByNotZoomTemplate;
use Domain\Products\Actions\BulkEdit\Find\GetProductByOrderingRule;
use Domain\Products\Actions\BulkEdit\Find\GetProductByOrderingRuleNot;
use Domain\Products\Actions\BulkEdit\Find\GetProductByParentId;
use Domain\Products\Actions\BulkEdit\Find\GetProductByProductType;
use Domain\Products\Actions\BulkEdit\Find\GetProductByPublishedOnSite;
use Domain\Products\Actions\BulkEdit\Find\GetProductByStatus;
use Domain\Products\Actions\BulkEdit\Find\GetProductByStatusNot;
use Domain\Products\Actions\BulkEdit\Find\GetProductByThumbnailTemplate;
use Domain\Products\Actions\BulkEdit\Find\GetProductByWeightBetween;
use Domain\Products\Actions\BulkEdit\Find\GetProductByWeightNotBetween;
use Domain\Products\Actions\BulkEdit\Find\GetProductByZoomTemplate;
use Domain\Products\Actions\BulkEdit\Find\GetProductTypeNotMatched;

enum SearchOptions: string
{
    case PARENT_PRODUCT_ID = 'parent_product';
    case KEYWORD_EXISTS_IN_FIELD = 'keyword_exists_in_field';
    case KEYWORD_DOES_NOT_EXISTS_IN_FIELD = 'keyword_does_not_exists_in_field';
    case KEYWORD_MATCHES_FIELD_EXACTLY = 'keyword_matches_field_exactly';
    case KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY = 'keyword does not match field exactly';
    case PRODUCT_TYPE_IS = 'product_type_is';
    case PRODUCT_TYPE_IS_NOT = 'product_type_is_not';
    case BRAND_IS = 'brand_is';
    case BRAND_IS_NOT = 'brand_is_not';
    case DEFAULT_DISTRIBUTOR_IS = 'default_distributor_is';
    case DEFAULT_DISTRIBUTOR_IS_NOT = 'default_distributor_is_not';
    case HAS_ANY_OF_SELECTED_ATTRIBUTES = 'has_any_of_selected_attributes';
    case DOES_NOT_HAVE_ANY_OF_SELECTED_ATTRIBUTES = 'does_not_have_any_of_selected_attributes';
    case HAS_ALL_OF_SELECTED_ATTRIBUTES = 'has_all_of_selected_attributes';
    case DOES_NOT_HAVE_ALL_OF_SELECTED_ATTRIBUTES = 'does_not_have_all_of_selected_attributes';
    case DEFAULT_CATEGORY_IS = 'default_category_is';
    case DEFAULT_CATEGORY_IS_NOT = 'default_category_is_not';
    case COMBINED_STOCK_QUANTITY_IS_BETWEEN = 'combined_stock_quantity_is_between';
    case COMBINED_STOCK_QUANTITY_IS_NOT_BETWEEN = 'combined_stock_quantity_is_not_between';
    case STATUS_IS = 'status_is';
    case STATUS_IS_NOT = 'status_is_not';
    case DEFAULT_OUT_OF_STOCK_STATUS_IS = 'default_out_of_stock_status_is';
    case DEFAULT_OUT_OF_STOCK_STATUS_IS_NOT = 'default_out_of_stock_status_is_not';
    case DEFAULT_COST_IS_BETWEEN = 'default_cost_is_between';
    case DEFAULT_COST_IS_NOT_BETWEEN = 'default_cost_is_not_between';
    case PUBLISHED_ON_SITE = 'published_on_site';
    case NOT_PUBLISHED_ON_SITE = 'not_published_on_site';
    case WEIGHT_IS_NOT_BETWEEN = 'weight_is_not_between';
    case WEIGHT_IS_BETWEEN = 'weight_is_between';
    case PRODUCT_THUMBNAIL_TEMPLATE_IS = 'product_thumbnail_template_is';
    case PRODUCT_THUMBNAIL_TEMPLATE_IS_NOT = 'product_thumbnail_template_is_not';
    case PRODUCT_DETAIL_TEMPLATE_IS = 'product_detail_template_is';
    case PRODUCT_DETAIL_TEMPLATE_IS_NOT = 'product_detail_template_is_not';
    case PRODUCT_ZOOM_TEMPLATE_IS = 'product_zoom_template_is';
    case PRODUCT_ZOOM_TEMPLATE_IS_NOT = 'product_zoom_template_is_not';
    case IS_INVENTORIED = 'is_inventoried';
    case IS_NOT_INVENTORIED = 'is_not_inventoried';
    case ORDERING_RULE_IS = 'ordering_rule_is';
    case ORDERING_RULE_IS_NOT = 'ordering_rule_is_not';
    case ASSIGNED_TO_DISCOUNT_LEVEL = 'assigned_to_discount_level';
    case NOT_ASSIGNED_TO_DISCOUNT_LEVEL = 'not_assigned_to_discount_level';
    case IS_PARENT = 'is_parent';
    case IS_CHILD = 'is_child';


    public static function options(): array
    {
        return [
            [
                'id' => self::KEYWORD_EXISTS_IN_FIELD,
                'name' => __('Keyword exists in field'),
                'component_type' => 'Keyword',
                'search_text' => __('Keyword keyKeyword exists in field keyFieldNameforLanguage'),
            ],
            [
                'id' => self::KEYWORD_DOES_NOT_EXISTS_IN_FIELD,
                'name' => __('keyword does not exist in field'),
                'component_type' => 'Keyword',
                'search_text' => __('keyword keyKeyword does not exist in field keyFieldNameforLanguage'),
            ],
            [
                'id' => self::KEYWORD_MATCHES_FIELD_EXACTLY,
                'name' => __('keyword matches field exactly'),
                'component_type' => 'Keyword',
                'search_text' => __('keyword keyKeyword matches field keyFieldNameforLanguage exactly'),
            ],
            [
                'id' => self::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY,
                'name' => __('keyword does not match field exactly'),
                'component_type' => 'Keyword',
                'search_text' => __('keyword keyKeyword does not match field keyFieldNameforLanguage exactly'),
            ],
            [
                'id' => self::PRODUCT_TYPE_IS,
                'name' => __('product type is'),
                'component_type' => 'ProductType',
                'search_text' => __('product type is keyKeyword'),
            ],
            [
                'id' => self::PRODUCT_TYPE_IS_NOT,
                'name' => __('product type is not'),
                'component_type' => 'ProductType',
                'search_text' => __('product type is not keyKeyword'),
            ],
            [
                'id' => self::BRAND_IS,
                'name' => __('brand is'),
                'component_type' => 'Brand',
                'search_text' => __('brand is keyKeyword'),
            ],
            [
                'id' => self::BRAND_IS_NOT,
                'name' => __('brand is not'),
                'component_type' => 'Brand',
                'search_text' => __('brand is not keyKeyword'),
            ],
            [
                'id' => self::DEFAULT_DISTRIBUTOR_IS,
                'name' => __('default distributor is'),
                'component_type' => 'Distributor',
                'search_text' => __('default distributor is keyKeyword'),
            ],
            [
                'id' => self::DEFAULT_DISTRIBUTOR_IS_NOT,
                'name' => __('default distributor is not'),
                'component_type' => 'Distributor',
                'search_text' => __('default distributor is not keyKeyword'),
            ],
            [
                'id' => self::HAS_ANY_OF_SELECTED_ATTRIBUTES,
                'name' => __('has any of selected attributes'),
                'component_type' => 'Attribute',
                'search_text' => __('has any of selected attributes keyKeyword'),
            ],
            [
                'id' => self::DOES_NOT_HAVE_ANY_OF_SELECTED_ATTRIBUTES,
                'name' => __('does not have any of selected attributes'),
                'component_type' => 'Attribute',
                'search_text' => __('does not have any of selected attributes keyKeyword'),
            ],
            [
                'id' => self::HAS_ALL_OF_SELECTED_ATTRIBUTES,
                'name' => __('has all of selected attributes'),
                'component_type' => 'Attribute',
                'search_text' => __('has all of selected attributes keyKeyword'),
            ],
            [
                'id' => self::DOES_NOT_HAVE_ALL_OF_SELECTED_ATTRIBUTES,
                'name' => __('does not have all of selected attributes'),
                'component_type' => 'Attribute',
                'search_text' => __('does not have all of selected attributes keyKeyword'),
            ],
            [
                'id' => self::DEFAULT_CATEGORY_IS,
                'name' => __('default category is'),
                'component_type' => 'Category',
                'search_text' => __('default category is keyKeyword'),
            ],
            [
                'id' => self::DEFAULT_CATEGORY_IS_NOT,
                'name' => __('default category is not'),
                'component_type' => 'Category',
                'search_text' => __('default category is not keyKeyword'),
            ],
            [
                'id' => self::COMBINED_STOCK_QUANTITY_IS_BETWEEN,
                'name' => __('combined stock quantity is between'),
                'component_type' => 'StockQuantity',
                'search_text' => __('combined stock quantity is between keyMin and keyMax'),
            ],
            [
                'id' => self::COMBINED_STOCK_QUANTITY_IS_NOT_BETWEEN,
                'name' => __('combined stock quantity is not between'),
                'component_type' => 'StockQuantity',
                'search_text' => __('combined stock quantity is not between keyMin and keyMax'),
            ],
            [
                'id' => self::STATUS_IS,
                'name' => __('status is'),
                'component_type' => 'Status',
                'search_text' => __('status is keyKeyword'),
            ],
            [
                'id' => self::STATUS_IS_NOT,
                'name' => __('status is not'),
                'component_type' => 'Status',
                'search_text' => __('status is not keyKeyword'),
            ],
            [
                'id' => self::DEFAULT_OUT_OF_STOCK_STATUS_IS,
                'name' => __('default out of stock status is'),
                'component_type' => 'StockStatus',
                'search_text' => __('default out of stock status is keyKeyword'),
            ],
            [
                'id' => self::DEFAULT_OUT_OF_STOCK_STATUS_IS_NOT,
                'name' => __('default out of stock status is not'),
                'component_type' => 'StockStatus',
                'search_text' => __('default out of stock status is not keyKeyword'),
            ],
            [
                'id' => self::DEFAULT_COST_IS_BETWEEN,
                'name' => __('default cost is between'),
                'component_type' => 'DefaultCost',
                'search_text' => __('default cost is between keyMin and keyMax'),
            ],
            [
                'id' => self::DEFAULT_COST_IS_NOT_BETWEEN,
                'name' => __('default cost is not between'),
                'component_type' => 'DefaultCost',
                'search_text' => __('default cost is not between keyMin and keyMax'),
            ],
            [
                'id' => self::PUBLISHED_ON_SITE,
                'name' => __('published on site'),
                'component_type' => 'PublishedOnSite',
                'search_text' => __('published on site keyKeyword'),
            ],
            [
                'id' => self::NOT_PUBLISHED_ON_SITE,
                'name' => __('not published on site'),
                'component_type' => 'PublishedOnSite',
                'search_text' => __('not published on site keyKeyword'),
            ],
            [
                'id' => self::WEIGHT_IS_BETWEEN,
                'name' => __('weight is between'),
                'component_type' => 'ProductWeight',
                'search_text' => __('weight is between keyMin and keyMax'),
            ],
            [
                'id' => self::WEIGHT_IS_NOT_BETWEEN,
                'name' => __('weight is not between'),
                'component_type' => 'ProductWeight',
                'search_text' => __('weight is not between keyMin and keyMax'),
            ],
            [
                'id' => self::PRODUCT_THUMBNAIL_TEMPLATE_IS,
                'name' => __('product\'s thumbnail template is'),
                'component_type' => 'ThumbnailTemplate',
                'search_text' => __('product\'s thumbnail template is keyKeyword'),
            ],
            [
                'id' => self::PRODUCT_THUMBNAIL_TEMPLATE_IS_NOT,
                'name' => __('product\'s thumbnail template is not'),
                'component_type' => 'ThumbnailTemplate',
                'search_text' => __('product\'s thumbnail template is not keyKeyword'),
            ],
            [
                'id' => self::PRODUCT_DETAIL_TEMPLATE_IS,
                'name' => __('product\'s detail template is'),
                'component_type' => 'DetailTemplate',
                'search_text' => __('product\'s detail template is keyKeyword'),
            ],
            [
                'id' => self::PRODUCT_DETAIL_TEMPLATE_IS_NOT,
                'name' => __('product\'s detail template is not'),
                'component_type' => 'DetailTemplate',
                'search_text' => __('product\'s detail template is not keyKeyword'),
            ],
            [
                'id' => self::PRODUCT_ZOOM_TEMPLATE_IS,
                'name' => __('product\'s zoom template is'),
                'component_type' => 'ZoomTemplate',
                'search_text' => __('product\'s zoom template is keyKeyword'),
            ],
            [
                'id' => self::PRODUCT_ZOOM_TEMPLATE_IS_NOT,
                'name' => __('product\'s zoom template is not'),
                'component_type' => 'ZoomTemplate',
                'search_text' => __('product\'s zoom template is not keyKeyword'),
            ],
            [
                'id' => self::IS_INVENTORIED,
                'name' => __('is inventoried'),
                'component_type' => 'EmptyWidget',
                'search_text' => __('is inventoried'),
            ],
            [
                'id' => self::IS_NOT_INVENTORIED,
                'name' => __('is not inventoried'),
                'component_type' => 'EmptyWidget',
                'search_text' => __('is not inventoried'),
            ],
            [
                'id' => self::PARENT_PRODUCT_ID,
                'name' => __('Parent product Id is'),
                'component_type' => 'ProductId',
                'search_text' => __('Parent product Id is keyKeyword'),
            ],
            [
                'id' => self::ORDERING_RULE_IS_NOT,
                'name' => __('ordering rule is not'),
                'component_type' => 'OrderingRule',
                'search_text' => __('ordering rule is not keyKeyword'),
            ],
            [
                'id' => self::ORDERING_RULE_IS,
                'name' => __('ordering rule is'),
                'component_type' => 'OrderingRule',
                'search_text' => __('ordering rule is keyKeyword'),
            ],
            [
                'id' => self::ASSIGNED_TO_DISCOUNT_LEVEL,
                'name' => __('assigned to discount level'),
                'component_type' => 'DiscountLevel',
                'search_text' => __('assigned to discount level keyKeyword'),
            ],
            [
                'id' => self::NOT_ASSIGNED_TO_DISCOUNT_LEVEL,
                'name' => __('not assigned to discount level'),
                'component_type' => 'DiscountLevel',
                'search_text' => __('not assigned to discount level keyKeyword'),
            ],
            [
                'id' => self::IS_PARENT,
                'name' => __('is parent'),
                'component_type' => 'EmptyWidget',
                'search_text' => __('is parent'),
            ],
            [
                'id' => self::IS_CHILD,
                'name' => __('is child'),
                'component_type' => 'EmptyWidget',
                'search_text' => __('is child'),
            ],
        ];
    }
    public function action()
    {
        return match ($this) {
            self::PARENT_PRODUCT_ID => GetProductByParentId::class,
            self::KEYWORD_EXISTS_IN_FIELD => GetProductByKeywordExists::class,
            self::KEYWORD_DOES_NOT_EXISTS_IN_FIELD => GetProductByKeywordNotExists::class,
            self::KEYWORD_MATCHES_FIELD_EXACTLY => GetProductByKeywordMatch::class,
            self::KEYWORD_DOES_NOT_MATCH_FIELD_EXACTLY => GetProductByKeywordNotMatch::class,
            self::PRODUCT_TYPE_IS => GetProductByProductType::class,
            self::PRODUCT_TYPE_IS_NOT => GetProductTypeNotMatched::class,
            self::BRAND_IS => GetProductByBrand::class,
            self::BRAND_IS_NOT => GetBrandNotMatched::class,
            self::DEFAULT_DISTRIBUTOR_IS => GetProductByDistributor::class,
            self::DEFAULT_DISTRIBUTOR_IS_NOT => GetProductByDistributorNot::class,
            self::HAS_ANY_OF_SELECTED_ATTRIBUTES => GetProductByAnyAttribute::class,
            self::DOES_NOT_HAVE_ANY_OF_SELECTED_ATTRIBUTES => GetProductByNotHaveAnyAttribute::class,
            self::HAS_ALL_OF_SELECTED_ATTRIBUTES => GetProductByAllAttribute::class,
            self::DOES_NOT_HAVE_ALL_OF_SELECTED_ATTRIBUTES => GetProductByNotHaveAllAttribute::class,
            self::DEFAULT_CATEGORY_IS => GetProductByDefaultCategory::class,
            self::DEFAULT_CATEGORY_IS_NOT => GetProductByDefaultCategoryNot::class,
            self::COMBINED_STOCK_QUANTITY_IS_BETWEEN => GetProductByCombinedStockBetween::class,
            self::COMBINED_STOCK_QUANTITY_IS_NOT_BETWEEN => GetProductByCombinedStockNotBetween::class,
            self::STATUS_IS => GetProductByStatus::class,
            self::STATUS_IS_NOT => GetProductByStatusNot::class,
            self::DEFAULT_OUT_OF_STOCK_STATUS_IS => GetProductByDefaultOutOfStatus::class,
            self::DEFAULT_OUT_OF_STOCK_STATUS_IS_NOT => GetProductByDefaultOutOfStatusNot::class,
            self::DEFAULT_COST_IS_BETWEEN => GetProductByDefaultCostBetween::class,
            self::DEFAULT_COST_IS_NOT_BETWEEN => GetProductByDefaultCostNotBetween::class,
            self::PUBLISHED_ON_SITE => GetProductByPublishedOnSite::class,
            self::NOT_PUBLISHED_ON_SITE => GetProductByNotPublishedOnSite::class,
            self::WEIGHT_IS_BETWEEN => GetProductByWeightBetween::class,
            self::WEIGHT_IS_NOT_BETWEEN => GetProductByWeightNotBetween::class,
            self::PRODUCT_THUMBNAIL_TEMPLATE_IS => GetProductByThumbnailTemplate::class,
            self::PRODUCT_THUMBNAIL_TEMPLATE_IS_NOT => GetProductByNotThumbnailTemplate::class,
            self::PRODUCT_DETAIL_TEMPLATE_IS => GetProductByDetailsTemplate::class,
            self::PRODUCT_DETAIL_TEMPLATE_IS_NOT => GetProductByNotDetailsTemplate::class,
            self::PRODUCT_ZOOM_TEMPLATE_IS => GetProductByZoomTemplate::class,
            self::PRODUCT_ZOOM_TEMPLATE_IS_NOT => GetProductByNotZoomTemplate::class,
            self::IS_INVENTORIED => GetProductByInventoried::class,
            self::IS_NOT_INVENTORIED => GetProductByNotInventoried::class,
            self::ORDERING_RULE_IS_NOT => GetProductByOrderingRuleNot::class,
            self::ORDERING_RULE_IS => GetProductByOrderingRule::class,
            self::ASSIGNED_TO_DISCOUNT_LEVEL => GetProductByDisocuntLevel::class,
            self::NOT_ASSIGNED_TO_DISCOUNT_LEVEL => GetProductByNotDisocuntLevel::class,
            self::IS_PARENT => GetProductByIsParent::class,
            self::IS_CHILD => GetProductByIsChild::class,

        };
    }
}
