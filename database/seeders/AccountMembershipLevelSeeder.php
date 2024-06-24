<?php

namespace Database\Seeders;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\AffiliateLevel;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductPricing;

class AccountMembershipLevelSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            Product::class,
            [
                'id', 'parent_product', 'title', 'subtitle', 'default_outofstockstatus_id', 'details_img_id', 'category_img_id', 'status', 'product_no', 'combined_stock_qty', 'default_cost', 'weight', 'created', 'default_distributor_id', 'fulfillment_rule_id', 'url_name', 'meta_title', 'meta_desc', 'meta_keywords', 'inventory_id', 'customs_description', 'tariff_number', 'country_origin', 'inventoried', 'shared_inventory_id', 'addtocart_setting', 'addtocart_external_label', 'addtocart_external_link', 'has_children'
            ],
            [
                [7493, null, 'Annual Enterprise Membership', '', 1, null, null, 1, '', -52.00, 0.0000, 0.00, '2016-02-04 20:06:38', null, NULL, 'annual-enterprise-membership', 'Annual Enterprise Membership', 'Annual Enterprise Membership', 'Annual Enterprise Membership', '', '', '', '', 0, NULL, '0', NULL, NULL, 0],
                [7494, null, 'Annual Medallion Membership', '', 1, null, null, 1, '', -547.00, 0.0000, 0.00, '2016-02-04 20:06:09', null, NULL, 'annual-medallion-membership', 'Annual Medallion Membership', 'Annual Medallion Membership', 'Annual Medallion Membership', '', '', '', '', 0, NULL, '0', NULL, NULL, 0],
                [7495, null, 'Annual Travel Membership', '', 1, null, null, 1, '', -13284.00, 0.0000, 0.00, '2016-02-04 20:04:32', null, NULL, 'annual-travel-membership', 'Annual Travel Membership', 'Annual Travel Membership', 'Annual Travel Membership', '', '', '', '', 0, NULL, '0', NULL, NULL, 0],
                [7496, null, 'Annual Basic Membership', '', 1, null, null, 1, '', -38098.00, 0.0000, 0.00, '2016-02-04 19:59:11', null, 0, 'annual-basic-membership', 'Annual Basic Membership', 'Annual Basic Membership', 'Annual Basic Membership', '', '', '', '', 0, '', '0', '', '', 0],
            ]
        );

        $this->bulkCreate(
            ProductDetail::class,
            [
                'product_id', 'summary', 'description', 'type_id', 'brand_id', 'rating', 'views_30days', 'views_90days', 'views_180days', 'views_1year', 'views_all', 'orders_30days', 'orders_90days', 'orders_180days', 'orders_1year', 'orders_all', 'downloadable', 'downloadable_file', 'default_category_id', 'orders_updated', 'views_updated', 'create_children_auto', 'display_children_grid', 'override_parent_description', 'allow_pricing_discount'
            ],
            [
                [7493, 'Annual Enterprise Membership', 'Annual Enterprise Membership', null, null, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0],
                [7494, 'Annual Medallion Membership', 'Annual Medallion Membership', null, null, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0],
                [7495, 'Annual Travel Membership', 'Annual Travel Membership', null, null, 0.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0],
                [7496, 'Annual Basic Membership', 'Annual Basic Membership', null, null, 5.0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0]
            ]
        );

        $this->bulkCreate(
            ProductPricing::class,
            [
                'product_id', 'site_id', 'price_reg', 'price_sale', 'onsale', 'min_qty', 'max_qty', 'feature', 'pricing_rule_id', 'ordering_rule_id', 'status', 'published_date'
            ],
            [
                [7493, null, 1250.0000, 0.0000, 0, 0.00, 1.00, 0, null, null, 0, '0000-00-00 00:00:00'],
                [7494, null, 395.0000, 0.0000, 0, 0.00, 1.00, 0, null, null, 0, '0000-00-00 00:00:00'],
                [7495, null, 67.0000, 0.0000, 0, 0.00, 1.00, 0, null, null, 0, '0000-00-00 00:00:00'],
                [7496, null, 0.0000, 0.0000, 0, 0.00, 1.00, 0, null, null, 0, '0000-00-00 00:00:00'],
            ]
        );

        $this->bulkCreate(
            AffiliateLevel::class,
            [
                'id', 'name', 'points'
            ],
            [
                [1, 'Basic', [
                    'order' => 0,
                    'subscription' => []
                ]],
                [2, 'Travel', [
                    'order' => 0,
                    'subscription' => [
                        'basic' => 0,
                        'travel' => 500,
                        'medallion' => 650,
                        'enterprise' => 1250,
                    ]
                ]],
                [3, 'Medallion', [
                    'order' => 150,
                    'subscription' => [
                        'basic' => 0,
                        'travel' => 2500,
                        'medallion' => 3250,
                        'enterprise' => 6500,
                    ]
                ]],
                [4, 'Enterprise', [
                    'order' => 300,
                    'subscription' => [
                        'basic' => 0,
                        'travel' => 7000,
                        'medallion' => 9000,
                        'enterprise' => 18000,
                    ]
                ]]
            ]
        );


        $this->bulkCreate(
            MembershipLevel::class,
            [
                'id', 'tag', 'name', 'rank', 'status', 'annual_product_id', 'monthly_product_id',
                'renewal_discount', 'description', 'signupemail_customer', 'renewemail_customer',
                'expirationalert1_email', 'expirationalert2_email', 'expiration_email', 'affiliate_level_id', 'is_default',
                'signuprenew_option',
            ],
            [
                [1, 'basic', 'Basic', 1, 1, 7496, null, 10.00, '', 0, 0, 0, 0, 0, 1, 0, 1],
                [2, 'travel', 'Travel', 5, 1, 7495, null, 10.00, '', 0, 0, 0, 0, 0, 2, 1, 1],
                [3, 'medallion', 'Medallion', 15, 1, 7494, null, 10.00, '', 0, 0, 0, 0, 0, 3, 0, 1],
                [4, 'enterprise', 'Enterprise', 20, 1, 7493, null, 5.00, '', 0, 0, 0, 0, 0, 4, 0, 1],
            ]
        );
    }
}
