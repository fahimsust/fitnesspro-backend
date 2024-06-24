<?php

use Domain\Payments\Models\PaymentAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('accessories_fields_products', function (Blueprint $table) {
            $table->foreign('accessories_fields_id')
                ->references('id')->on('accessories_fields');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('account_specialties', function (Blueprint $table) {
            $table->foreign('parent_id')
              ->references('id')->on('account_specialties');
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->foreign('default_billing_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('default_shipping_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('affiliate_id')
                ->references('id')->on('affiliates');
            $table->foreign('cim_profile_id')
                ->references('id')->on('cim_profile');
            $table->foreign('photo_id')
                ->references('id')->on('photos');
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('loyaltypoints_id')
                ->references('id')->on('loyaltypoints');
        });
        Schema::table('accounts_addressbook', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('accounts_addtl_fields', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('field_id')
                ->references('id')->on('custom_fields');
            $table->foreign('section_id')
                ->references('id')->on('custom_forms_sections');
            $table->foreign('form_id')
                ->references('id')->on('custom_forms');
        });
        Schema::table('accounts_bulletins', function (Blueprint $table) {
            $table->foreign('account_id')
              ->references('id')->on('accounts');
        });
        Schema::table('accounts_cims', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('cim_profile_id')
                ->references('id')->on('cim_profile');
        });
        Schema::table('accounts_comments', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('replyto_id')
                ->references('id')->on('accounts');
        });
        Schema::table('accounts_discounts_used', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('discount_id')
                ->references('id')->on('discount');
        });
        Schema::rename('discounts', 'discounts_old');
        Schema::table('accounts_loyaltypoints', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('loyaltypoints_level_id')
                ->references('id')->on('loyaltypoints_levels');
        });
        Schema::table('accounts_loyaltypoints_credits', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('loyaltypoints_level_id')
                ->references('id')->on('loyaltypoints_levels');
            $table->foreign('shipment_id')
                ->references('id')->on('orders_shipments');
        });
        Schema::table('accounts_loyaltypoints_debits', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('loyaltypoints_level_id')
                ->references('id')->on('loyaltypoints_levels');
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
        Schema::table('accounts_membership_attributes', function (Blueprint $table) {
            $table->foreign('section_id')
              ->references('id')->on('accounts_membership_attributes_sections');
        });
        Schema::table('accounts_membership_levels', function (Blueprint $table) {
            $table->foreign('annual_product_id')
                ->references('id')->on('products');
            $table->foreign('monthly_product_id')
                ->references('id')->on('products');
            $table->foreign('affiliate_level_id')
                ->references('id')->on('affiliates_levels');
        });
        Schema::table('accounts_membership_levels_attributes', function (Blueprint $table) {
            $table->foreign('level_id')
                ->references('id')->on('accounts_membership_levels');
            $table->foreign('attribute_id')
                ->references('id')->on('accounts_membership_attributes');
        });
        Schema::table('accounts_membership_levels_settings', function (Blueprint $table) {
            $table->foreign('level_id')
              ->references('id')->on('accounts_membership_levels');
        });
        Schema::table('accounts_memberships', function (Blueprint $table) {
            $table->renameColumn('membership_id', 'level_id');
            $table->foreign('level_id')
              ->references('id')->on('accounts_membership_levels');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
        Schema::table('accounts_memberships_payment_methods', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('payment_method_id')
                ->references('id')->on('payment_methods');
            $table->foreign('gateway_account_id')
                ->references('id')->on('payment_gateways_accounts');
        });
        Schema::table('accounts_messages', function (Blueprint $table) {
            $table->foreign('replied_id')
              ->references('id')->on('accounts');
            $table->foreign('to_id')
                ->references('id')->on('accounts');
            $table->foreign('from_id')
                ->references('id')->on('accounts');
            $table->foreign('header_id')
                ->references('id')->on('accounts_messages_headers');
        });
        Schema::table('accounts_onmind', function (Blueprint $table) {
            $table->foreign('account_id')
              ->references('id')->on('accounts');
        });
        Schema::table('accounts_onmind_comments', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('onmind_id')
                ->references('id')->on('accounts_onmind');
        });
        Schema::table('accounts_onmind_likes', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('onmind_id')
                ->references('id')->on('accounts_onmind');
        });
        Schema::table('accounts_specialties', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('specialty_id')
                ->references('id')->on('account_specialties');
        });
        Schema::table('accounts_templates_sent', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('template_id')
                ->references('id')->on('message_templates');
        });
        Schema::table('accounts_types', function (Blueprint $table) {
            $table->foreign('discount_level_id')
                ->references('id')->on('discounts_levels');
            $table->foreign('loyaltypoints_id')
                ->references('id')->on('loyaltypoints');
            $table->foreign('membership_level_id')
                ->references('id')->on('accounts_membership_levels');
            $table->foreign('affiliate_level_id')
                ->references('id')->on('affiliates_levels');
            $table->foreign('custom_form_id')
                ->references('id')->on('custom_forms');
        });
        Schema::table('accounts_views', function (Blueprint $table) {
            $table->foreign('account_id')
              ->references('id')->on('accounts');
            $table->dropColumn('profile_id');
        });
        Schema::table('admin_emails_sent', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('template_id')
                ->references('id')->on('message_templates');
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
        Schema::table('admin_levels_menus', function (Blueprint $table) {
            $table->foreign('level_id')
                ->references('id')->on('admin_levels');
            $table->foreign('menu_id')
                ->references('id')->on('menu');
        });
        Schema::table('admin_users', function (Blueprint $table) {
            $table->foreign('level_id')
                ->references('id')->on('admin_levels');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('admin_users_distributors', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('admin_users');
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
            $table->foreign('affiliate_level_id')
                ->references('id')->on('affiliates_levels');
        });
        Schema::table('affiliates_payments', function (Blueprint $table) {
            $table->foreign('affiliate_id')
              ->references('id')->on('affiliates');
        });
        Schema::table('affiliates_payments_referrals', function (Blueprint $table) {
            $table->foreign('payment_id')
                ->references('id')->on('affiliates_payments');
            $table->foreign('referral_id')
                ->references('id')->on('affiliates_referrals');
        });
        Schema::table('affiliates_referrals', function (Blueprint $table) {
            $table->foreign('affiliate_id')
                ->references('id')->on('affiliates');
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('status_id')
                ->references('id')->on('affiliates_referrals_statuses');
            $table->foreign('type_id')
                ->references('id')->on('affiliates_referrals_types');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('photo')
                ->references('id')->on('photos');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('articles_categories', function (Blueprint $table) {
            $table->foreign('parent_id')
              ->references('id')->on('articles_categories');
        });
        Schema::table('articles_comments', function (Blueprint $table) {
            $table->foreign('article_id')
                ->references('id')->on('articles');
            $table->foreign('createdby')
                ->references('id')->on('accounts');
        });
        Schema::table('articles_views', function (Blueprint $table) {
            $table->foreign('article_id')
                ->references('id')->on('articles');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('attributes', function (Blueprint $table) {
            $table->foreign('type_id')
              ->references('id')->on('attributes_types');
        });
        Schema::table('attributes_options', function (Blueprint $table) {
            $table->foreign('attribute_id')
              ->references('id')->on('attributes');
        });

        Schema::table('attributes_sets_attributes', function (Blueprint $table) {
            $table->foreign('attribute_id')
                ->references('id')->on('attributes');
            $table->foreign('set_id')
                ->references('id')->on('attributes_sets');
        });
        Schema::table('automated_emails', function (Blueprint $table) {
            $table->foreign('message_template_id')
              ->references('id')->on('message_templates');
        });
        Schema::table('automated_emails_accounttypes', function (Blueprint $table) {
            $table->foreign('automated_email_id')
                ->references('id')->on('automated_emails');
            $table->foreign('account_type_id')
                ->references('id')->on('accounts_types');
        });
        Schema::table('automated_emails_sites', function (Blueprint $table) {
            $table->foreign('automated_email_id')
                ->references('id')->on('automated_emails');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('banners_clicks', function (Blueprint $table) {
            $table->foreign('banner_id')
              ->references('id')->on('banners_images');
        });
        Schema::table('banners_images', function (Blueprint $table) {
            $table->foreign('campaign_id')
              ->references('id')->on('banners_campaigns');
        });
        Schema::table('banners_shown', function (Blueprint $table) {
            $table->foreign('banner_id')
              ->references('id')->on('banners_images');
        });

        Schema::table('bookingas_options', function (Blueprint $table) {
            $table->foreign('bookingas_id')
              ->references('id')->on('bookingas');
        });
        Schema::table('bookingas_products', function (Blueprint $table) {
            $table->foreign('bookingas_id')
                ->references('id')->on('bookingas');
            $table->foreign('product')
                ->references('id')->on('products');
        });
        Schema::table('bulkedit_change_products', function (Blueprint $table) {
            $table->foreign('change_id')
                ->references('id')->on('bulkedit_change');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')
              ->references('id')->on('categories');
        });
//        Schema::table('categories_attributes', function (Blueprint $table) {
//            $table->foreign('category_id')
//                ->references('id')->on('categories');
//            $table->foreign('option_id')
//                ->references('id')->on('attributes_options');
//        });
//        Schema::table('categories_attributes_rules', function (Blueprint $table) {
//            $table->foreign('category_id')
//                ->references('id')->on('categories');
//        });
        Schema::table('categories_brands', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('brand_id')
                ->references('id')->on('brands');
        });
        Schema::table('categories_featured', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('categories_products_assn', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('categories_products_hide', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('categories_products_ranks', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('categories_products_sorts', function (Blueprint $table) {
            $table->foreign('category_id')
              ->references('id')->on('categories');
        });
        Schema::table('categories_rules', function (Blueprint $table) {
            $table->foreign('category_id')
              ->references('id')->on('categories');
        });
        Schema::table('categories_rules_attributes', function (Blueprint $table) {
            $table->foreign('rule_id')
                ->references('id')->on('categories_rules');
            $table->foreign('value_id')
                ->references('id')->on('attributes_options');
        });
        Schema::table('categories_settings', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('settings_template_id')
                ->references('id')->on('categories_settings_templates');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
        });
        Schema::table('categories_settings_sites', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('settings_template_id')
                ->references('id')->on('categories_settings_templates');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('search_form_id')
                ->references('id')->on('search_forms');
        });
        Schema::table('categories_settings_sites_modulevalues', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
            $table->foreign('module_id')
                ->references('id')->on('modules');
            $table->foreign('field_id')
                ->references('id')->on('modules_fields');
        });
        Schema::table('categories_settings_templates', function (Blueprint $table) {
            $table->foreign('settings_template_id')
                ->references('id')->on('categories_settings_templates');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('search_form_id')
                ->references('id')->on('search_forms');
        });
        Schema::table('categories_settings_templates_modulevalues', function (Blueprint $table) {
            $table->foreign('settings_template_id', 'set_tmp_id')
                ->references('id')->on('categories_settings_templates');
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
            $table->foreign('module_id')
                ->references('id')->on('modules');
            $table->foreign('field_id')
                ->references('id')->on('modules_fields');
        });
        Schema::table('categories_types', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('type_id')
                ->references('id')->on('products_types');
        });
        Schema::table('cim_profile', function (Blueprint $table) {
            $table->foreign('gateway_account_id')
              ->references('id')->on(PaymentAccount::Table());
        });
        Schema::table('cim_profile_paymentprofile', function (Blueprint $table) {
            $table->foreign('profile_id')
              ->references('id')->on('cim_profile');
        });
        Schema::table('countries_regions', function (Blueprint $table) {
            $table->foreign('country_id')
              ->references('id')->on('countries');
        });
        Schema::table('custom_forms_sections', function (Blueprint $table) {
            $table->foreign('form_id')
              ->references('id')->on('custom_forms');
        });
        Schema::table('custom_forms_sections_fields', function (Blueprint $table) {
            $table->foreign('section_id')
                ->references('id')->on('custom_forms_sections');
            $table->foreign('field_id')
                ->references('id')->on('custom_fields');
        });
        Schema::table('custom_forms_show', function (Blueprint $table) {
            $table->foreign('form_id')
              ->references('id')->on('custom_forms');
        });
        Schema::table('custom_forms_show_products', function (Blueprint $table) {
            $table->foreign('form_id')
                ->references('id')->on('custom_forms');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('custom_forms_show_producttypes', function (Blueprint $table) {
            $table->foreign('form_id')
                ->references('id')->on('custom_forms');
            $table->foreign('product_type_id')
                ->references('id')->on('products_types');
        });
        Schema::table('discount_advantage', function (Blueprint $table) {
            $table->foreign('discount_id')
                ->references('id')->on('discount');
            $table->foreign('advantage_type_id')
                ->references('id')->on('discount_advantage_types');
            $table->foreign('apply_shipping_id')
                ->references('id')->on('accounts_addressbook');
        });
        Schema::table('discount_advantage_products', function (Blueprint $table) {
            $table->foreign('advantage_id')
                ->references('id')->on('discount_advantage');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('discount_advantage_producttypes', function (Blueprint $table) {
            $table->foreign('advantage_id')
                ->references('id')->on('discount_advantage');
            $table->foreign('producttype_id')
                ->references('id')->on('products_types');
        });
        Schema::table('discount_rule', function (Blueprint $table) {
            $table->foreign('discount_id')
              ->references('id')->on('discount');
        });
        Schema::table('discount_rule_condition', function (Blueprint $table) {
            $table->foreign('rule_id')
                ->references('id')->on('discount_rule');
            $table->foreign('condition_type_id')
                ->references('id')->on('discount_rule_condition_types');
        });
        Schema::table('discount_rule_condition_accounttypes', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('accounttype_id')
                ->references('id')->on('accounts_types');
        });
        Schema::table('discount_rule_condition_attributes', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('attributevalue_id')
                ->references('id')->on('attributes_options');
        });
        Schema::table('discount_rule_condition_countries', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('discount_rule_condition_distributors', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
        });
        Schema::table('discount_rule_condition_membershiplevels', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('membershiplevel_id', 'memlvl_id')
                ->references('id')->on('accounts_membership_levels');
        });
        Schema::table('discount_rule_condition_onsalestatuses', function (Blueprint $table) {
            $table->foreign('condition_id')
              ->references('id')->on('discount_rule_condition');
        });
        Schema::table('discount_rule_condition_outofstockstatuses', function (Blueprint $table) {
            $table->foreign('condition_id')
              ->references('id')->on('discount_rule_condition');
        });
        Schema::table('discount_rule_condition_productavailabilities', function (Blueprint $table) {
            $table->foreign('condition_id', 'con_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('availability_id', 'avail_id')
                ->references('id')->on('products_availability');
        });
        Schema::table('discount_rule_condition_products', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('discount_rule_condition_producttypes', function (Blueprint $table) {
            $table->foreign('condition_id', 'cond_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('producttype_id', 'ptype_id')
                ->references('id')->on('products_types');
        });
        Schema::table('discount_rule_condition_sites', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('discount_rule_condition');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });

        Schema::table('discounts_levels_products', function (Blueprint $table) {
            $table->foreign('discount_level_id')
                ->references('id')->on('discounts_levels');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });

        Schema::table('display_templates', function (Blueprint $table) {
            $table->foreign('type_id')
              ->references('id')->on('display_templates_types');
        });
        Schema::table('distributors_availabilities', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('availability_id')
                ->references('id')->on('products_availability');
        });
        Schema::table('distributors_canadapost', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('distributors_endicia', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('distributors_fedex', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('distributors_genericshipping', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('distributors_shipping_flatrates', function (Blueprint $table) {
            $table->foreign('distributor_shippingmethod_id', 'dis_smeth_id')
              ->references('id')->on('distributors_shipping_methods');
        });
        Schema::table('distributors_shipping_gateways', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('shipping_gateway_id')
                ->references('id')->on('shipping_gateways');
        });
        Schema::table('distributors_shipping_methods', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('shipping_method_id')
                ->references('id')->on('shipping_methods');
        });
        Schema::table('distributors_shipstation', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('distributors_ups', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('distributors_usps', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('state_id')
                ->references('id')->on('states');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->foreign('createdby')
                ->references('id')->on('accounts');
            $table->foreign('photo')
                ->references('id')->on('photos');
        });
        Schema::table('events_toattend', function (Blueprint $table) {
            $table->foreign('userid')
                ->references('id')->on('accounts');
            $table->foreign('eventid')
                ->references('id')->on('events');
        });
        Schema::table('events_views', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('event_id')
                ->references('id')->on('events');
        });
        Schema::table('faqs_categories', function (Blueprint $table) {
            $table->foreign('faqs_id')
                ->references('id')->on('faqs');
            $table->foreign('categories_id')
                ->references('id')->on('faq_categories');
        });
        Schema::table('faqs_categories_translations', function (Blueprint $table) {
            $table->foreign('language_id')
                ->references('id')->on('languages');
            $table->foreign('categories_id')
                ->references('id')->on('faq_categories');
        });
        Schema::table('faqs_translations', function (Blueprint $table) {
            $table->foreign('faqs_id')
                ->references('id')->on('faqs');
            $table->foreign('language_id')
                ->references('id')->on('languages');
        });
        Schema::table('filters_attributes', function (Blueprint $table) {
            $table->foreign('attribute_id')
                ->references('id')->on('attributes');
            $table->foreign('filter_id')
                ->references('id')->on('filters');
        });
        Schema::table('filters_availabilities', function (Blueprint $table) {
            $table->foreign('filter_id')
                ->references('id')->on('filters');
        });
        Schema::table('filters_categories', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('filter_id')
                ->references('id')->on('filters');
        });
        Schema::table('filters_pricing', function (Blueprint $table) {
            $table->foreign('filter_id')
                ->references('id')->on('filters');
        });
        Schema::table('filters_productoptions', function (Blueprint $table) {
            $table->foreign('filter_id')
                ->references('id')->on('filters');
        });
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('friend_id')
                ->references('id')->on('accounts');
        });
        Schema::table('friends', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('friend_id')
                ->references('id')->on('accounts');
        });
        Schema::table('friends_updates', function (Blueprint $table) {
            $table->foreign('friend_id')
                ->references('id')->on('accounts');
        });
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('gift_cards_transactions', function (Blueprint $table) {
            $table->foreign('giftcard_id')
                ->references('id')->on('gift_cards');
            $table->foreign('admin_user_id')
                ->references('id')->on('users');
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
        Schema::table('giftregistry', function (Blueprint $table) {
            $table->foreign('shipto_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('giftregistry_items', function (Blueprint $table) {
            $table->foreign('registry_id')
                ->references('id')->on('giftregistry');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('parent_product')
                ->references('id')->on('products');
        });
        Schema::table('giftregistry_items_purchased', function (Blueprint $table) {
            $table->foreign('registry_item_id')
                ->references('id')->on('giftregistry_items');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('order_product_id')
                ->references('id')->on('orders_products');
        });

        //Completed Data Correction
        Schema::table('instructors_certfiles', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('inventory_gateways_accounts', function (Blueprint $table) {
            $table->foreign('gateway_id')
                ->references('id')->on('inventory_gateways');
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('base_currency')
                ->references('id')->on('currencies');
        });
        Schema::table('inventory_gateways_fields', function (Blueprint $table) {
            $table->foreign('gateway_id')
                ->references('id')->on('inventory_gateways');
        });
        Schema::table('inventory_gateways_orders', function (Blueprint $table) {
            $table->foreign('gateway_account_id')
                ->references('id')->on('inventory_gateways_accounts');
            $table->foreign('shipment_id')
                ->references('id')->on('orders_shipments');
        });
        Schema::table('inventory_gateways_scheduledtasks', function (Blueprint $table) {
            $table->foreign('gateway_account_id')
                ->references('id')->on('inventory_gateways_accounts');
        });
        Schema::table('inventory_gateways_scheduledtasks_products', function (Blueprint $table) {
            $table->foreign('products_distributors_id', 'product_distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('products_id')
                ->references('id')->on('products');
            $table->foreign('task_id')
                ->references('id')->on('inventory_gateways_scheduledtasks');
        });
        Schema::table('inventory_gateways_sites', function (Blueprint $table) {
            $table->foreign('gateway_account_id')
                ->references('id')->on('inventory_gateways_accounts');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('languages_translations', function (Blueprint $table) {
            $table->foreign('content_id')
                ->references('id')->on('languages_content');
            $table->foreign('language_id')
                ->references('id')->on('languages');
        });
        Schema::table('loyaltypoints', function (Blueprint $table) {
            $table->foreign('active_level_id')
                ->references('id')->on('loyaltypoints_levels');
        });
        Schema::table('loyaltypoints_levels', function (Blueprint $table) {
            $table->foreign('loyaltypoints_id')
                ->references('id')->on('loyaltypoints');
        });
        Schema::table('menu', function (Blueprint $table) {
            $table->foreign('parent')
                ->references('id')->on('menu');
        });
        Schema::table('menus_catalogcategories', function (Blueprint $table) {
            $table->foreign('menu_id')
                ->references('id')->on('menus');
            $table->foreign('category_id')
                ->references('id')->on('categories');
        });
        Schema::table('menus_categories', function (Blueprint $table) {
            $table->foreign('menu_id')
                ->references('id')->on('menus');
            $table->foreign('category_id')
                ->references('id')->on('categories');
        });
        Schema::table('menus_links', function (Blueprint $table) {
            $table->foreign('menu_id')
                ->references('id')->on('menus');
            $table->foreign('links_id')
                ->references('id')->on('menu_links');
        });
        Schema::table('menus_menus', function (Blueprint $table) {
            $table->foreign('menu_id')
                ->references('id')->on('menus');
            $table->foreign('child_menu_id')
                ->references('id')->on('menus');
        });
        Schema::table('menus_pages', function (Blueprint $table) {
            $table->foreign('menu_id')
                ->references('id')->on('menus');
            $table->foreign('page_id')
                ->references('id')->on('pages');
        });
        Schema::table('menus_sites', function (Blueprint $table) {
            $table->foreign('menu_id')
                ->references('id')->on('menus');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('mods_account_ads', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('mods_account_ads_clicks', function (Blueprint $table) {
            $table->foreign('ad_id')
                ->references('id')->on('mods_account_ads');
        });
        Schema::table('mods_account_certifications', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('mods_account_certifications_files', function (Blueprint $table) {
            $table->foreign('certification_id')
                ->references('id')->on('mods_account_certifications');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('mods_account_files', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('mods_dates_auto_orderrules_action', function (Blueprint $table) {
            $table->foreign('dao_id')
                ->references('id')->on('mods_dates_auto_orderrules');
            $table->foreign('criteria_orderingruleid', 'criteria_order_rule_id')
                ->references('id')->on('products_rules_ordering');
            $table->foreign('criteria_siteid', 'criteria_site_id')
                ->references('id')->on('sites');
            $table->foreign('changeto_orderingruleid', 'changeto_order_rule_id')
                ->references('id')->on('products_rules_ordering');
        });
        Schema::table('mods_dates_auto_orderrules_excludes', function (Blueprint $table) {
            $table->foreign('dao_id')
                ->references('id')->on('mods_dates_auto_orderrules');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('mods_dates_auto_orderrules_products', function (Blueprint $table) {
            $table->foreign('dao_id')
                ->references('id')->on('mods_dates_auto_orderrules');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('mods_resort_details_amenities', function (Blueprint $table) {
            $table->foreign('resort_details_id')
                ->references('attribute_option_id')->on('mods_resort_details');
            $table->foreign('amenity_id')
                ->references('id')->on('mod_resort_details_amenities');
        });
        Schema::table('mods_trip_flyers', function (Blueprint $table) {
            $table->foreign('orders_products_id')
                ->references('id')->on('orders_products');
            $table->foreign('photo_id')
                ->references('id')->on('photos');
        });
        Schema::table('mods_trip_flyers_settings', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('photo_id')
                ->references('id')->on('photos');
        });
        Schema::table('modules_admin_controllers', function (Blueprint $table) {
            $table->foreign('module_id')
                ->references('id')->on('modules');
        });
        Schema::table('modules_crons', function (Blueprint $table) {
            $table->foreign('module_id')
                ->references('id')->on('modules');
        });
        Schema::table('modules_fields', function (Blueprint $table) {
            $table->foreign('module_id')
                ->references('id')->on('modules');
        });
        Schema::table('modules_site_controllers', function (Blueprint $table) {
            $table->foreign('module_id')
                ->references('id')->on('modules');
        });
        Schema::table('modules_templates_modules', function (Blueprint $table) {
            $table->foreign('template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
            $table->foreign('module_id')
                ->references('id')->on('modules');
        });
        Schema::table('modules_templates', function (Blueprint $table) {
            $table->foreign('parent_template_id')
                ->references('id')->on('modules_templates');
        });
        Schema::table('modules_templates_sections', function (Blueprint $table) {
            $table->foreign('template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
        });

        ///M Finished

        Schema::table('options_templates_images', function (Blueprint $table) {
            $table->foreign('template_id')
                ->references('id')->on('options_templates');
            $table->foreign('image_id')
                ->references('id')->on('images');
        });
        Schema::table('options_templates_options', function (Blueprint $table) {
            $table->foreign('template_id')
                ->references('id')->on('options_templates');
        });
        Schema::table('options_templates_options_custom', function (Blueprint $table) {
            $table->foreign('value_id')
                ->references('id')->on('options_templates_options_values');
        });
        Schema::table('options_templates_options_values', function (Blueprint $table) {
            $table->foreign('option_id')
                ->references('id')->on('options_templates_options');
            $table->foreign('image_id')
                ->references('id')->on('images');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('account_billing_id')->nullable()->change();
            $table->unsignedBigInteger('account_shipping_id')->nullable()->change();
            $table->unsignedBigInteger('site_id')->change();
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('account_billing_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('account_shipping_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('orders_activities', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
        Schema::table('orders_billing', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('bill_state_id')
                ->references('id')->on('states');
            $table->foreign('bill_country_id')
                ->references('id')->on('countries');
        });
        Schema::table('orders_customforms', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('form_id')
                ->references('id')->on('custom_forms');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('product_type_id')
                ->references('id')->on('products_types');
        });
        Schema::table('orders_discounts', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('discount_id')
                ->references('id')->on('discount');
            $table->foreign('advantage_id')
                ->references('id')->on('discount_advantage');
        });
        Schema::table('orders_notes', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->change();
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
        //need to check this foreign key//
        Schema::table('orders_packages', function (Blueprint $table) {
            $table->foreign('shipment_id')
                ->references('id')->on('orders_shipments');
        });
        Schema::table('orders_products', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('actual_product_id')
                ->references('id')->on('products');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('package_id')
                ->references('id')->on('orders_packages');
            // $table->foreign('parent_product_id')
            //     ->references('id')->on('products');
            $table->foreign('registry_item_id')
                ->references('id')->on('giftregistry_items');
        });
        Schema::table('orders_products_customfields', function (Blueprint $table) {
            $table->foreign('orders_products_id')
                ->references('id')->on('orders_products');
            $table->foreign('form_id')
                ->references('id')->on('custom_forms');
            $table->foreign('section_id')
                ->references('id')->on('custom_forms_sections');
            $table->foreign('field_id')
                ->references('id')->on('custom_fields');
        });
        Schema::table('orders_products_customsinfo', function (Blueprint $table) {
            $table->foreign('orders_products_id')
                ->references('id')->on('orders_products');
        });
        Schema::table('orders_products_discounts', function (Blueprint $table) {
            $table->foreign('orders_products_id')
                ->references('id')->on('orders_products');
            $table->foreign('discount_id')
                ->references('id')->on('discount');
            $table->foreign('advantage_id')
                ->references('id')->on('discount_advantage');
        });
        Schema::table('orders_products_options', function (Blueprint $table) {
            $table->foreign('orders_products_id')
                ->references('id')->on('orders_products');
            $table->foreign('value_id')
                ->references('id')->on('products_options_values');
        });
        Schema::table('orders_products_sentemails', function (Blueprint $table) {
            $table->foreign('op_id')
                ->references('id')->on('orders_products');
            $table->foreign('email_id')
                ->references('id')->on('message_templates');
        });
        Schema::table('orders_shipments', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('ship_method_id')
                ->references('id')->on('shipping_methods');
            $table->foreign('order_status_id')
                ->references('id')->on('orders_statuses');
        });
        Schema::table('orders_shipments_labels', function (Blueprint $table) {
            $table->foreign('shipment_id')
                ->references('id')->on('orders_shipments');
            $table->foreign('package_id')
                ->references('id')->on('orders_packages');
            $table->foreign('label_size_id')
                ->references('id')->on('shipping_label_sizes');
        });
        Schema::table('orders_shipping', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('ship_state_id')
                ->references('id')->on('states');
            $table->foreign('ship_country_id')
                ->references('id')->on('countries');
        });
        Schema::table('orders_tasks', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
        Schema::table('orders_transactions', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('account_billing_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('payment_method_id')
                ->references('id')->on('payment_methods');
            $table->foreign('gateway_account_id')
                ->references('id')->on(PaymentAccount::Table());
            $table->foreign('cim_payment_profile_id')
                ->references('id')->on('cim_profile_paymentprofile');
        });
        Schema::table('orders_transactions_billing', function (Blueprint $table) {
            $table->foreign('orders_transactions_id')
                ->references('id')->on('orders_transactions');
            $table->foreign('bill_state_id')
                ->references('id')->on('states');
            $table->foreign('bill_country_id')
                ->references('id')->on('countries');
        });
        Schema::table('orders_transactions_credits', function (Blueprint $table) {
            $table->foreign('orders_transactions_id')
                ->references('id')->on('orders_transactions');
        });
        //O finished
        Schema::table('pages_categories', function (Blueprint $table) {
            $table->foreign('parent_category_id')
                ->references('id')->on('pages_categories');
        });
        Schema::table('pages_categories_pages', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('pages_categories');
            $table->foreign('page_id')
                ->references('id')->on('pages');
        });
        Schema::table('pages_settings', function (Blueprint $table) {
            $table->foreign('page_id')
                ->references('id')->on('pages');
            $table->foreign('settings_template_id')
                ->references('id')->on('pages_settings_templates');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
        });
        Schema::table('pages_settings_sites', function (Blueprint $table) {
            $table->foreign('page_id')
                ->references('id')->on('pages');
            $table->foreign('settings_template_id')
                ->references('id')->on('pages_settings_templates');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
        });
        Schema::table('pages_settings_sites_modulevalues', function (Blueprint $table) {
            $table->foreign('page_id')
                ->references('id')->on('pages');
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
            $table->foreign('field_id')
                ->references('id')->on('modules_fields');
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('module_id')
                ->references('id')->on('modules');
        });
        Schema::table('pages_settings_templates', function (Blueprint $table) {
            $table->foreign('settings_template_id')
                ->references('id')->on('pages_settings_templates');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
        });
        Schema::table('pages_settings_templates_modulevalues', function (Blueprint $table) {
            $table->foreign('settings_template_id', 'setting_template_id')
                ->references('id')->on('pages_settings_templates');
            $table->foreign('field_id', 'fields_id')
                ->references('id')->on('modules_fields');
            $table->foreign('section_id', 'sections_id')
                ->references('id')->on('display_sections');
            $table->foreign('module_id', 'modules_id')
                ->references('id')->on('modules');
        });
        Schema::table('payment_gateways_accounts', function (Blueprint $table) {
            $table->foreign('gateway_id')
                ->references('id')->on('payment_gateways');
        });
        Schema::table('payment_gateways_accounts_limitcountries', function (Blueprint $table) {
            $table->foreign('gateway_account_id', 'gateways_account_id')
                ->references('id')->on(PaymentAccount::Table());
            $table->foreign('country_id', 'countries_id')
                ->references('id')->on('countries');
        });
        Schema::table('payment_gateways_errors', function (Blueprint $table) {
            $table->foreign('gateway_account_id')
                ->references('id')->on(PaymentAccount::Table());
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreign('gateway_id')
                ->references('id')->on('payment_gateways');
        });
        Schema::table('payment_methods_limitcountries', function (Blueprint $table) {
            $table->foreign('payment_method_id')
                ->references('id')->on('payment_methods');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('photos', function (Blueprint $table) {
            $table->foreign('addedby')
                ->references('id')->on('accounts');
            $table->foreign('album')
                ->references('id')->on('photos_albums');
        });
        Schema::table('photos_comments', function (Blueprint $table) {
            $table->foreign('photo_id')
                ->references('id')->on('photos');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('photos_favorites', function (Blueprint $table) {
            $table->foreign('photo_id')
                ->references('id')->on('photos');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('pricing_rules_levels', function (Blueprint $table) {
            $table->foreign('rule_id')
                ->references('id')->on('pricing_rules');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('parent_product')
                 ->references('id')->on('products');
            $table->foreign('details_img_id')
                ->references('id')->on('images');
            $table->foreign('category_img_id')
                ->references('id')->on('images');
            $table->foreign('default_distributor_id')
                ->references('id')->on('distributors');
        });
        Schema::table('products_accessories', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('accessory_id')
                ->references('id')->on('products');
        });
        Schema::table('products_accessories_fields', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('accessories_fields_id')
                ->references('id')->on('accessories_fields');
        });
        Schema::table('products_attributes', function (Blueprint $table) {
            $table->foreign('option_id')
                ->references('id')->on('attributes_options');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_details', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('type_id')
                ->references('id')->on('products_types');
            $table->foreign('brand_id')
                ->references('id')->on('brands');
            $table->foreign('default_category_id')
                ->references('id')->on('categories');
        });
        Schema::table('products_distributors', function (Blueprint $table) {
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_images', function (Blueprint $table) {
            $table->foreign('image_id')
                ->references('id')->on('images');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_log', function (Blueprint $table) {
            $table->foreign('productdistributor_id')
                ->references('id')->on('products_distributors');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_needschildren', function (Blueprint $table) {
            $table->foreign('option_id')
                ->references('id')->on('products_options');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_options', function (Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')->on('products_options_types');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });

        Schema::table('products_options_values', function (Blueprint $table) {
            $table->foreign('option_id')
                ->references('id')->on('products_options');
            $table->foreign('image_id')
                ->references('id')->on('images');
        });
        Schema::table('products_pricing', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('pricing_rule_id')
                ->references('id')->on('pricing_rules');
            $table->foreign('ordering_rule_id')
                ->references('id')->on('products_rules_ordering');
        });
        Schema::table('products_pricing_temp', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('pricing_rule_id')
                ->references('id')->on('pricing_rules');
            $table->foreign('ordering_rule_id')
                ->references('id')->on('products_rules_ordering');
        });
        Schema::table('products_related', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('related_id')
                ->references('id')->on('products');
        });
        //Create Resorts Table
        Schema::create('resorts_old', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60);
            $table->text('description');
            $table->text('comments');
            $table->string('logo', 80);
            $table->unsignedBigInteger('airport_id');
            $table->string('fax', 20);
            $table->string('contact_addr', 80);
            $table->string('contact_city', 35);
            $table->unsignedBigInteger('contact_state_id');
            $table->string('contact_zip', 20);
            $table->unsignedBigInteger('contact_country_id');
            $table->string('mgr_lname', 35);
            $table->string('mgr_fname', 35);
            $table->string('mgr_phone', 20);
            $table->string('mgr_email', 65);
            $table->string('mgr_fax', 20);
            $table->text('notes');
            $table->text('transfer_info');
            $table->string('url_name', 200);
            $table->binary('details');
            $table->text('schedule_info');
            $table->text('suz_comments');
            $table->string('link_resort', 255);
            $table->string('concierge_name', 65);
            $table->string('concierge_email', 85);
            $table->string('facebook_fanpage', 255);
            $table->text('giftfund_info');
            $table->tinyInteger('resort_type');
            $table->unsignedBigInteger('group_id');
            $table->tinyInteger('status');
            $table->string('user', 20);
            $table->string('password', 20);
            $table->unsignedBigInteger('region_id');
        });
        ///Add foreign key
        Schema::table('resorts_old', function (Blueprint $table) {
            $table->foreign('airport_id')
                ->references('id')->on('airports');
            $table->foreign('contact_state_id')
                ->references('id')->on('states');
            $table->foreign('contact_country_id')
                ->references('id')->on('countries');
            $table->foreign('region_id')
                ->references('id')->on('countries_regions');
        });
        //Need to Create Resorts Table
        Schema::table('products_resort', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_reviews', function (Blueprint $table) {
            $table->foreign('item_id')
                ->references('id')->on('products');
        });
        Schema::table('products_rules_fulfillment_conditions_items', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('products_rules_fulfillment_conditions');
        });
        Schema::table('products_rules_fulfillment_distributors', function (Blueprint $table) {
            $table->foreign('rule_id')
                ->references('id')->on('products_rules_fulfillment');
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
        });
        Schema::table('products_rules_fulfillment_conditions', function (Blueprint $table) {
            $table->foreign('rule_id')
                ->references('id')->on('products_rules_fulfillment');
        });
        Schema::table('products_rules_fulfillment_rules', function (Blueprint $table) {
            $table->foreign('parent_rule_id')
                ->references('id')->on('products_rules_fulfillment');
            $table->foreign('child_rule_id')
                ->references('id')->on('products_rules_fulfillment');
        });
        Schema::table('products_rules_ordering_conditions', function (Blueprint $table) {
            $table->foreign('rule_id')
                ->references('id')->on('products_rules_ordering_rules');
        });
        Schema::table('products_rules_ordering_conditions_items', function (Blueprint $table) {
            $table->foreign('condition_id')
                ->references('id')->on('products_rules_ordering_conditions');
            $table->foreign('item_id')
                ->references('id')->on('products');
        });
        Schema::table('products_rules_ordering_rules', function (Blueprint $table) {
            $table->foreign('parent_rule_id')
                ->references('id')->on('products_rules_ordering');
            $table->foreign('child_rule_id')
                ->references('id')->on('products_rules_ordering');
        });
        Schema::table('products_settings', function (Blueprint $table) {
            $table->foreign('settings_template_id')
                ->references('id')->on('products_settings_templates');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
        });
        Schema::table('products_settings_sites', function (Blueprint $table) {
            $table->foreign('settings_template_id')
                ->references('id')->on('products_settings_templates');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('products_settings_sites_modulevalues', function (Blueprint $table) {
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('module_id')
                ->references('id')->on('modules');
            $table->foreign('field_id')
                ->references('id')->on('modules_fields');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('products_settings_templates', function (Blueprint $table) {
            $table->foreign('settings_template_id')
                ->references('id')->on('products_settings_templates');
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('module_template_id')
                ->references('id')->on('modules_templates');
        });
        Schema::table('products_settings_templates_modulevalues', function (Blueprint $table) {
            $table->foreign('settings_template_id', 'category_setting_template_id')
                ->references('id')->on('categories_settings_templates');
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
            $table->foreign('module_id')
                ->references('id')->on('modules');
            $table->foreign('field_id')
                ->references('id')->on('modules_fields');
        });
        Schema::table('products_specialties', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('specialty_id')
                ->references('id')->on('account_specialties');
        });
        Schema::table('products_specialties_check', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_tasks', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
        Schema::table('products_types_attributes_sets', function (Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')->on('products_types');
            $table->foreign('set_id')
                ->references('id')->on('attributes_sets');
        });
        Schema::table('products_viewed', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')->on('products');
        });

        //P finished
        Schema::table('saved_cart', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('saved_cart_discounts', function (Blueprint $table) {
            $table->foreign('saved_cart_id')
                ->references('id')->on('saved_cart');
        });
        Schema::table('saved_cart_items', function (Blueprint $table) {
            $table->foreign('saved_cart_id')
                ->references('id')->on('saved_cart');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('parent_product')
                ->references('id')->on('products');
            $table->foreign('registry_item_id')
                ->references('id')->on('giftregistry_items');
            $table->foreign('accessory_field_id')
                ->references('id')->on('accessories_fields');
            $table->foreign('distributor_id')
                ->references('id')->on('distributors');
        });
        Schema::table('saved_cart_items_customfields', function (Blueprint $table) {
            // $table->foreign('saved_cart_item_id')
            //     ->references('id')->on('saved_cart_items');
            $table->foreign('field_id')
                ->references('id')->on('custom_fields');
            $table->foreign('section_id')
                ->references('id')->on('custom_forms_sections');
            $table->foreign('form_id')
                ->references('id')->on('custom_forms');
        });
        Schema::table('saved_cart_items_options', function (Blueprint $table) {
            $table->foreign('saved_cart_item_id')
                ->references('id')->on('saved_cart_items');
        });
        Schema::table('saved_cart_items_options_customvalues', function (Blueprint $table) {
            $table->foreign('saved_cart_item_id')
                ->references('id')->on('saved_cart_items');
            $table->foreign('option_id')
                ->references('id')->on('products_options_values');
        });
        Schema::table('saved_order', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('saved_cart_id')
                ->references('id')->on('saved_cart');
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('saved_order_discounts', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('discount_id')
                ->references('id')->on('discount');
        });
        Schema::table('saved_order_information', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')->on('orders');
            $table->foreign('account_billing_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('account_shipping_id')
                ->references('id')->on('accounts_addressbook');
            $table->foreign('bill_state_id')
                ->references('id')->on('states');
            $table->foreign('bill_country_id')
                ->references('id')->on('countries');
            $table->foreign('ship_state_id')
                ->references('id')->on('states');
            $table->foreign('ship_country_id')
                ->references('id')->on('countries');
            $table->foreign('payment_method_id')
                ->references('id')->on('payment_methods');
            $table->foreign('shipping_method_id')
                ->references('id')->on('payment_methods');
        });
        //need to check this match only 2
        Schema::table('search_forms_fields', function (Blueprint $table) {
            $table->foreign('search_id')
                ->references('id')->on('search_forms');
        });
        Schema::table('search_forms_sections', function (Blueprint $table) {
            $table->foreign('form_id')
                ->references('id')->on('search_forms');
        });
        Schema::table('search_forms_sections_fields', function (Blueprint $table) {
            $table->foreign('field_id')
                ->references('id')->on('search_forms_fields');
        });
        Schema::table('shipping_carriers', function (Blueprint $table) {
            $table->foreign('gateway_id')
                ->references('id')->on('shipping_gateways');
        });
        Schema::table('shipping_carriers_shipto', function (Blueprint $table) {
            $table->foreign('shipping_carriers_id')
                ->references('id')->on('shipping_carriers');
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });
        Schema::table('shipping_label_sizes', function (Blueprint $table) {
            $table->foreign('gateway_id')
                ->references('id')->on('shipping_gateways');
        });
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->foreign('carrier_id')
                ->references('id')->on('shipping_carriers');
        });
        Schema::table('shipping_package_types', function (Blueprint $table) {
            $table->foreign('carrier_id')
                ->references('id')->on('shipping_carriers');
        });
        Schema::table('shipping_signature_options', function (Blueprint $table) {
            $table->foreign('carrier_id')
                ->references('id')->on('shipping_carriers');
        });
        Schema::table('sites_categories', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('category_id')
                ->references('id')->on('categories');
        });
        Schema::table('sites_currencies', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('currency_id')
                ->references('id')->on('currencies');
        });
        Schema::table('sites_inventory_rules', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('rule_id')
                ->references('id')->on('inventory_rules');
        });
        Schema::table('sites_languages', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('language_id')
                ->references('id')->on('languages');
        });
        Schema::table('sites_message_templates', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('sites_packingslip', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('sites_payment_methods', function (Blueprint $table) {
            $table->foreign('payment_method_id')
                ->references('id')->on('payment_methods');
            $table->foreign('gateway_account_id')
                ->references('id')->on(PaymentAccount::Table());
            $table->foreign('site_id')
                ->references('id')->on('sites');
        });
        Schema::table('sites_settings', function (Blueprint $table) {
            $table->foreign('default_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('search_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('home_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('default_category_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('default_product_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('account_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('cart_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('checkout_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('page_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('affiliate_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('wishlist_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('default_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('default_category_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('default_product_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('home_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('account_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('search_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('cart_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('checkout_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('page_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('affiliate_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('wishlist_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('catalog_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('catalog_module_template_id')
                ->references('id')->on('modules_templates');
            $table->foreign('offline_layout_id')
                ->references('id')->on('display_layouts');
            $table->foreign('default_category_search_form_id')
                ->references('id')->on('search_forms');
        });
        Schema::table('sites_settings_modulevalues', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('section_id')
                ->references('id')->on('display_sections');
            $table->foreign('module_id')
                ->references('id')->on('modules');
            $table->foreign('field_id')
                ->references('id')->on('modules_fields');
        });
        Schema::table('sites_tax_rules', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('tax_rule_id')
                ->references('id')->on('tax_rules');
        });
        Schema::table('sites_themes', function (Blueprint $table) {
            $table->foreign('site_id')
                ->references('id')->on('sites');
            $table->foreign('theme_id')
                ->references('id')->on('display_themes');
        });

        Schema::table('tax_rules_locations', function (Blueprint $table) {
            $table->foreign('tax_rule_id')
                ->references('id')->on('tax_rules');
            $table->foreign('country_id')
                ->references('id')->on('countries');
            $table->foreign('state_id')
                ->references('id')->on('states');
        });
        Schema::table('tax_rules_product_types', function (Blueprint $table) {
            $table->foreign('tax_rule_id')
                ->references('id')->on('tax_rules');
            $table->foreign('type_id')
                ->references('id')->on('products_types');
        });
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign('account_id')
                ->references('id')->on('accounts');
        });
        Schema::table('wishlists_items', function (Blueprint $table) {
            $table->foreign('wishlist_id')
                ->references('id')->on('wishlists');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('parent_product')
                ->references('id')->on('products');
            $table->foreign('parent_wishlist_items_id')
                ->references('id')->on('wishlists_items');
            $table->foreign('accessory_field_id')
                ->references('id')->on('accessories_fields');
        });
        Schema::table('wishlists_items_customfields', function (Blueprint $table) {
            $table->foreign('wishlists_item_id')
                ->references('id')->on('wishlists_items');
            $table->foreign('form_id')
                ->references('id')->on('custom_forms');
            $table->foreign('section_id')
                ->references('id')->on('custom_forms_sections');
            $table->foreign('field_id')
                ->references('id')->on('custom_fields');
        });
        Schema::table('wishlists_items_options', function (Blueprint $table) {
            $table->foreign('wishlists_item_id')
                ->references('id')->on('wishlists_items');
        });
        Schema::table('wishlists_items_options_customvalues', function (Blueprint $table) {
            $table->foreign('wishlists_item_id')
                ->references('id')->on('wishlists_items');
            $table->foreign('option_id')
                ->references('id')->on('products_options_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resorts_old');
        Schema::table('accessories_fields_products', function (Blueprint $table) {
            $table->dropForeign(['accessories_fields_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('account_specialties', function (Blueprint $table) {
            $table->dropForeign('account_specialties_parent_id_foreign');
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign(['default_billing_id']);
            $table->dropForeign(['default_shipping_id']);
            $table->dropForeign(['affiliate_id']);
            $table->dropForeign(['cim_profile_id']);
            $table->dropForeign(['photo_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['loyaltypoints_id']);
        });
        Schema::table('accounts_addressbook', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('accounts_addtl_fields', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['field_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['form_id']);
        });
        Schema::table('accounts_cims', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['cim_profile_id']);
        });
        Schema::table('accounts_comments', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['replyto_id']);
        });
        Schema::table('accounts_discounts_used', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['discount_id']);
        });

        Schema::table('accounts_loyaltypoints', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['loyaltypoints_level_id']);
        });
        Schema::table('accounts_loyaltypoints_credits', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['loyaltypoints_level_id']);
            $table->dropForeign(['shipment_id']);
        });
        Schema::table('accounts_loyaltypoints_debits', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['loyaltypoints_level_id']);
            $table->dropForeign(['order_id']);
        });
        Schema::table('accounts_membership_attributes', function (Blueprint $table) {
            $table->dropForeign('accounts_membership_attributes_section_id_foreign');
        });
        Schema::table('accounts_membership_levels', function (Blueprint $table) {
            $table->dropForeign('accounts_membership_levels_annual_product_id_foreign');
            $table->dropForeign('accounts_membership_levels_monthly_product_id_foreign');
            $table->dropForeign('accounts_membership_levels_affiliate_level_id_foreign');
        });
        Schema::table('accounts_membership_levels_attributes', function (Blueprint $table) {
            $table->dropForeign('accounts_membership_levels_attributes_level_id_foreign');
            $table->dropForeign('accounts_membership_levels_attributes_attribute_id_foreign');
        });
        Schema::table('accounts_membership_levels_settings', function (Blueprint $table) {
            $table->dropForeign('accounts_membership_levels_settings_level_id_foreign');
        });
        Schema::table('accounts_memberships', function (Blueprint $table) {
            $table->renameColumn('level_id', 'membership_id');
            $table->dropForeign('accounts_memberships_level_id_foreign');
            $table->dropForeign('accounts_memberships_account_id_foreign');
            $table->dropForeign('accounts_memberships_product_id_foreign');
            $table->dropForeign('accounts_memberships_order_id_foreign');
        });
        Schema::table('accounts_memberships_payment_methods', function (Blueprint $table) {
            $table->dropForeign('accounts_memberships_payment_methods_site_id_foreign');
            $table->dropForeign('accounts_memberships_payment_methods_payment_method_id_foreign');
            $table->dropForeign('accounts_memberships_payment_methods_gateway_account_id_foreign');
        });
        Schema::table('accounts_messages', function (Blueprint $table) {
            $table->dropForeign(['replied_id']);
            $table->dropForeign(['to_id']);
            $table->dropForeign(['from_id']);
            $table->dropForeign(['header_id']);
        });
        Schema::table('accounts_onmind', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
        });
        Schema::table('accounts_onmind_comments', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['onmind_id']);
            $table->dropForeign(['comment_id']);
        });
        Schema::table('accounts_onmind_likes', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['onmind_id']);
        });
        Schema::table('accounts_specialties', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['specialty_id']);
        });
        Schema::table('accounts_templates_sent', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['template_id']);
        });
        Schema::table('accounts_types', function (Blueprint $table) {
            $table->dropForeign(['discount_level_id']);
            $table->dropForeign(['loyaltypoints_id']);
            $table->dropForeign(['membership_level_id']);
            $table->dropForeign(['affiliate_level_id']);
            $table->dropForeign(['custom_form_id']);
        });
        Schema::table('accounts_views', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->integer('profile_id')->nullable();
            //$table->dropColumn('profile_id']);
        });
        Schema::table('admin_emails_sent', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['template_id']);
            $table->dropForeign(['order_id']);
        });
        Schema::table('admin_levels_menus', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->dropForeign(['menu_id']);
        });
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->dropForeign(['account_id']);
        });
        Schema::table('admin_users_distributors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['distributor_id']);
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['affiliate_level_id']);
        });
        Schema::table('affiliates_payments', function (Blueprint $table) {
            $table->dropForeign(['affiliate_id']);
        });
        Schema::table('affiliates_payments_referrals', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropForeign(['referral_id']);
        });
        Schema::table('affiliates_referrals', function (Blueprint $table) {
            $table->dropForeign(['affiliate_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['status_id']);
            $table->dropForeign(['type_id']);
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });
        Schema::table('attributes_options', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
        });

        Schema::table('attributes_sets_attributes', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropForeign(['set_id']);
        });
        Schema::table('automated_emails', function (Blueprint $table) {
            $table->dropForeign(['message_template_id']);
        });
        Schema::table('automated_emails_accounttypes', function (Blueprint $table) {
            $table->dropForeign(['automated_email_id']);
            $table->dropForeign(['account_type_id']);
        });
        Schema::table('automated_emails_sites', function (Blueprint $table) {
            $table->dropForeign(['automated_email_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('bookingas_options', function (Blueprint $table) {
            $table->dropForeign(['bookingas_id']);
        });
        Schema::table('bookingas_products', function (Blueprint $table) {
            $table->dropForeign(['bookingas_id']);
            $table->dropForeign(['product']);
        });
        Schema::table('bulkedit_change_products', function (Blueprint $table) {
            $table->dropForeign(['change_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
//        Schema::table('categories_attributes', function (Blueprint $table) {
//            $table->dropForeign(['category_id']);
//            $table->dropForeign(['option_id']);
//        });
//        Schema::table('categories_attributes_rules', function (Blueprint $table) {
//            $table->dropForeign(['category_id']);
//            $table->dropForeign(['value_id']);
//        });
        Schema::table('categories_brands', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
        });
        Schema::table('categories_featured', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('categories_products_assn', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('categories_products_hide', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('categories_products_ranks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('categories_products_sorts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::table('categories_rules', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::table('categories_rules_attributes', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
            $table->dropForeign(['value_id']);
        });
        Schema::table('categories_settings', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['layout_id']);
            $table->dropForeign(['module_template_id']);
        });
        Schema::table('categories_settings_sites', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['layout_id']);
            $table->dropForeign(['module_template_id']);
            $table->dropForeign(['search_form_id']);
        });
        Schema::table('categories_settings_sites_modulevalues', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['module_id']);
            $table->dropForeign(['field_id']);
        });
        Schema::table('categories_settings_templates', function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['layout_id']);
            $table->dropForeign(['module_template_id']);
            $table->dropForeign(['search_form_id']);
        });
        Schema::table('categories_settings_templates_modulevalues', function (Blueprint $table) {
            $table->dropForeign('set_tmp_id');
            $table->dropForeign(['section_id']);
            $table->dropForeign(['module_id']);
            $table->dropForeign(['field_id']);
        });
        Schema::table('categories_types', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['type_id']);
        });
        Schema::table('cim_profile', function (Blueprint $table) {
            $table->dropForeign(['gateway_account_id']);
        });
        Schema::table('cim_profile_paymentprofile', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
        });
        Schema::table('countries_regions', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
        });
        Schema::table('custom_forms_sections', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
        });
        Schema::table('custom_forms_sections_fields', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropForeign(['field_id']);
        });
        Schema::table('custom_forms_show', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
        });
        Schema::table('custom_forms_show_products', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('custom_forms_show_producttypes', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->dropForeign(['product_type_id']);
        });
        Schema::table('discount_advantage', function (Blueprint $table) {
            $table->dropForeign(['discount_id']);
            $table->dropForeign(['advantage_type_id']);
            $table->dropForeign(['apply_shipping_id']);
        });
        Schema::table('discount_advantage_products', function (Blueprint $table) {
            $table->dropForeign(['advantage_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('discount_advantage_producttypes', function (Blueprint $table) {
            $table->dropForeign(['advantage_id']);
            $table->dropForeign(['producttype_id']);
        });
        Schema::table('discount_rule', function (Blueprint $table) {
            $table->dropForeign(['discount_id']);
        });
        Schema::table('discount_rule_condition', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
            $table->dropForeign(['condition_type_id']);
        });
        Schema::table('discount_rule_condition_accounttypes', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['accounttype_id']);
        });
        Schema::table('discount_rule_condition_attributes', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['attributevalue_id']);
        });
        Schema::table('discount_rule_condition_countries', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('discount_rule_condition_distributors', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['distributor_id']);
        });
        Schema::table('discount_rule_condition_membershiplevels', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign('memlvl_id');
        });
        Schema::table('discount_rule_condition_onsalestatuses', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
        });
        Schema::table('discount_rule_condition_outofstockstatuses', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
        });
        Schema::table('discount_rule_condition_productavailabilities', function (Blueprint $table) {
            $table->dropForeign('con_id');
            $table->dropForeign('avail_id');
        });
        Schema::table('discount_rule_condition_products', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('discount_rule_condition_producttypes', function (Blueprint $table) {
            $table->dropForeign('cond_id');
            $table->dropForeign('ptype_id');
        });
        Schema::table('discount_rule_condition_sites', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['site_id']);
        });

        Schema::table('discounts_levels_products', function (Blueprint $table) {
            $table->dropForeign(['discount_level_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('display_templates', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });
        Schema::table('distributors_availabilities', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['availability_id']);
        });
        Schema::table('distributors_canadapost', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('distributors_endicia', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('distributors_fedex', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('distributors_genericshipping', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('distributors_shipping_flatrates', function (Blueprint $table) {
            $table->dropForeign('dis_smeth_id');
        });
        Schema::table('distributors_shipping_gateways', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['shipping_gateway_id']);
        });
        Schema::table('distributors_shipping_methods', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['shipping_method_id']);
        });
        Schema::table('distributors_shipstation', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('distributors_ups', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('distributors_usps', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['createdby']);
            $table->dropForeign(['photo']);
        });
        Schema::table('events_toattend', function (Blueprint $table) {
            $table->dropForeign(['userid']);
            $table->dropForeign(['eventid']);
        });
        Schema::table('events_views', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['event_id']);
        });
        Schema::table('faqs_categories', function (Blueprint $table) {
            $table->dropForeign(['faqs_id']);
            $table->dropForeign(['categories_id']);
        });

        Schema::table('faqs_categories_translations', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropForeign(['categories_id']);
        });
        Schema::table('faqs_translations', function (Blueprint $table) {
            $table->dropForeign(['faqs_id']);
            $table->dropForeign(['language_id']);
        });
        Schema::table('filters_attributes', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropForeign(['filter_id']);
        });
        Schema::table('filters_availabilities', function (Blueprint $table) {
            $table->dropForeign(['filter_id']);
        });
        Schema::table('filters_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['filter_id']);
        });
        Schema::table('filters_pricing', function (Blueprint $table) {
            $table->dropForeign(['filter_id']);
        });
        Schema::table('filters_productoptions', function (Blueprint $table) {
            $table->dropForeign(['filter_id']);
        });
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['friend_id']);
        });
        Schema::table('friends', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['friend_id']);
        });
        Schema::table('friends_updates', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['friend_id']);
        });
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
        });
        Schema::table('gift_cards_transactions', function (Blueprint $table) {
            $table->dropForeign(['giftcard_id']);
            $table->dropForeign(['admin_user_id']);
            $table->dropForeign(['order_id']);
        });
        Schema::table('giftregistry', function (Blueprint $table) {
            $table->dropForeign(['shipto_id']);
            $table->dropForeign(['account_id']);
        });
        Schema::table('giftregistry_items', function (Blueprint $table) {
            $table->dropForeign(['registry_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['parent_product']);
        });
        Schema::table('giftregistry_items_purchased', function (Blueprint $table) {
            $table->dropForeign(['registry_item_id']);
            $table->dropForeign(['account_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['order_product_id']);
        });
        Schema::table('inventory_gateways_accounts', function (Blueprint $table) {
            $table->dropForeign(['gateway_id']);
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['base_currency']);
        });
        Schema::table('inventory_gateways_fields', function (Blueprint $table) {
            $table->dropForeign(['gateway_id']);
        });
        Schema::table('inventory_gateways_orders', function (Blueprint $table) {
            $table->dropForeign(['gateway_account_id']);
            $table->dropForeign(['shipment_id']);
        });
        Schema::table('inventory_gateways_scheduledtasks', function (Blueprint $table) {
            $table->dropForeign(['gateway_account_id']);
        });
        Schema::table('inventory_gateways_scheduledtasks_products', function (Blueprint $table) {
            $table->dropForeign('product_distributor_id');
            $table->dropForeign(['products_id']);
            $table->dropForeign(['task_id']);
        });
        Schema::table('inventory_gateways_sites', function (Blueprint $table) {
            $table->dropForeign(['gateway_account_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('languages_translations', function (Blueprint $table) {
            $table->dropForeign(['content_id']);
            $table->dropForeign(['language_id']);
        });
        Schema::table('loyaltypoints', function (Blueprint $table) {
            $table->dropForeign(['active_level_id']);
        });
        Schema::table('loyaltypoints_levels', function (Blueprint $table) {
            $table->dropForeign(['loyaltypoints_id']);
        });
        Schema::table('menu', function (Blueprint $table) {
            $table->dropForeign(['parent']);
        });
        Schema::table('menus_catalogcategories', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::table('menus_categories', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::table('menus_links', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['links_id']);
        });
        Schema::table('menus_menus', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['child_menu_id']);
        });
        Schema::table('menus_pages', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['page_id']);
        });
        Schema::table('menus_sites', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('mods_account_ads', function (Blueprint $table) {
            $table->dropForeign('mods_account_ads_account_id_foreign');
        });
        Schema::table('mods_account_ads_clicks', function (Blueprint $table) {
            $table->dropForeign('mods_account_ads_clicks_ad_id_foreign');
        });
        Schema::table('mods_account_certifications', function (Blueprint $table) {
            $table->dropForeign('mods_account_certifications_account_id_foreign');
        });
        Schema::table('mods_account_certifications_files', function (Blueprint $table) {
            $table->dropForeign('mods_account_certifications_files_certification_id_foreign');
            $table->dropForeign('mods_account_certifications_files_site_id_foreign');
        });
        Schema::table('mods_account_files', function (Blueprint $table) {
            $table->dropForeign('mods_account_files_account_id_foreign');
            $table->dropForeign('mods_account_files_site_id_foreign');
        });
        Schema::table('mods_dates_auto_orderrules_action', function (Blueprint $table) {
            $table->dropForeign('mods_dates_auto_orderrules_action_dao_id_foreign');
            $table->dropForeign('criteria_order_rule_id');
            $table->dropForeign('criteria_site_id');
            $table->dropForeign('changeto_order_rule_id');
        });
        Schema::table('mods_dates_auto_orderrules_excludes', function (Blueprint $table) {
            $table->dropForeign('mods_dates_auto_orderrules_excludes_dao_id_foreign');
            $table->dropForeign('mods_dates_auto_orderrules_excludes_product_id_foreign');
        });
        Schema::table('mods_dates_auto_orderrules_products', function (Blueprint $table) {
            $table->dropForeign('mods_dates_auto_orderrules_products_dao_id_foreign');
            $table->dropForeign('mods_dates_auto_orderrules_products_product_id_foreign');
        });

        Schema::table('mods_resort_details_amenities', function (Blueprint $table) {
            $table->dropForeign('mods_resort_details_amenities_resort_details_id_foreign');
            $table->dropForeign('mods_resort_details_amenities_amenity_id_foreign');
        });
        Schema::table('mods_trip_flyers', function (Blueprint $table) {
            $table->dropForeign('mods_trip_flyers_orders_products_id_foreign');
            $table->dropForeign('mods_trip_flyers_photo_id_foreign');
        });
        Schema::table('mods_trip_flyers_settings', function (Blueprint $table) {
            $table->dropForeign('mods_trip_flyers_settings_account_id_foreign');
            $table->dropForeign('mods_trip_flyers_settings_photo_id_foreign');
        });
        Schema::table('modules_admin_controllers', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
        });
        Schema::table('modules_crons', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
        });
        Schema::table('modules_fields', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
        });
        Schema::table('modules_site_controllers', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
        });
        Schema::table('modules_templates_modules', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['module_id']);
        });
        Schema::table('modules_templates', function (Blueprint $table) {
            $table->dropForeign(['parent_template_id']);
        });
        Schema::table('modules_templates_sections', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropForeign(['section_id']);
        });

        Schema::table('options_templates_images', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropForeign(['image_id']);
        });
        Schema::table('options_templates_options', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
        });
        Schema::table('options_templates_options_custom', function (Blueprint $table) {
            $table->dropForeign(['value_id']);
        });
        Schema::table('options_templates_options_values', function (Blueprint $table) {
            $table->dropForeign(['option_id']);
            $table->dropForeign(['image_id']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['account_billing_id']);
            $table->dropForeign(['account_shipping_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('orders_activities', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('orders_billing', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['bill_state_id']);
            $table->dropForeign(['bill_country_id']);
        });
        Schema::table('orders_customforms', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['form_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_type_id']);
        });
        Schema::table('orders_discounts', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['discount_id']);
            $table->dropForeign(['advantage_id']);
        });
        Schema::table('orders_notes', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('orders_packages', function (Blueprint $table) {
            $table->dropForeign(['shipment_id']);
        });
        Schema::table('orders_products', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['actual_product_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['package_id']);
            $table->dropForeign(['parent_product_id']);
            $table->dropForeign(['registry_item_id']);
        });
        Schema::table('orders_products_customfields', function (Blueprint $table) {
            $table->dropForeign(['orders_products_id']);
            $table->dropForeign(['form_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['field_id']);
        });
        Schema::table('orders_products_customsinfo', function (Blueprint $table) {
            $table->dropForeign(['orders_products_id']);
        });
        Schema::table('orders_products_discounts', function (Blueprint $table) {
            $table->dropForeign(['orders_products_id']);
            $table->dropForeign(['discount_id']);
            $table->dropForeign(['advantage_id']);
        });
        Schema::table('orders_products_options', function (Blueprint $table) {
            $table->dropForeign(['orders_products_id']);
            $table->dropForeign(['value_id']);
        });
        Schema::table('orders_products_sentemails', function (Blueprint $table) {
            $table->dropForeign(['op_id']);
            $table->dropForeign(['email_id']);
        });
        Schema::table('orders_shipments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['ship_method_id']);
            $table->dropForeign(['order_status_id']);
        });
        Schema::table('orders_shipments_labels', function (Blueprint $table) {
            $table->dropForeign(['shipment_id']);
            $table->dropForeign(['package_id']);
            $table->dropForeign(['label_size_id']);
        });
        Schema::table('orders_shipping', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['ship_state_id']);
            $table->dropForeign(['ship_country_id']);
        });
        Schema::table('orders_tasks', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
        Schema::table('orders_transactions', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['account_billing_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['gateway_account_id']);
            $table->dropForeign(['cim_payment_profile_id']);
        });
        Schema::table('orders_transactions_billing', function (Blueprint $table) {
            $table->dropForeign(['orders_transactions_id']);
            $table->dropForeign(['bill_state_id']);
            $table->dropForeign(['bill_country_id']);
        });
        Schema::table('orders_transactions_credits', function (Blueprint $table) {
            $table->dropForeign(['orders_transactions_id']);
        });
        Schema::table('pages_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_category_id']);
        });
        Schema::table('pages_categories_pages', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['page_id']);
        });
        Schema::table('pages_settings', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['module_template_id']);
            $table->dropForeign(['layout_id']);
        });
        Schema::table('pages_settings_sites', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['layout_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['module_template_id']);
        });
        Schema::table('pages_settings_sites_modulevalues', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['field_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['module_id']);
        });
        Schema::table('pages_settings_templates', function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['module_template_id']);
            $table->dropForeign(['layout_id']);
        });
        Schema::table('pages_settings_templates_modulevalues', function (Blueprint $table) {
            $table->dropForeign('setting_template_id');
            $table->dropForeign('fields_id');
            $table->dropForeign('sections_id');
            $table->dropForeign('modules_id');
        });
        Schema::table('payment_gateways_accounts', function (Blueprint $table) {
            $table->dropForeign(['gateway_id']);
        });
        Schema::table('payment_gateways_accounts_limitcountries', function (Blueprint $table) {
            $table->dropForeign('gateways_account_id');
            $table->dropForeign('countries_id');
        });
        Schema::table('payment_gateways_errors', function (Blueprint $table) {
            $table->dropForeign(['gateway_account_id']);
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign(['gateway_id']);
        });
        Schema::table('payment_methods_limitcountries', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('photos', function (Blueprint $table) {
            $table->dropForeign(['addedby']);
            $table->dropForeign(['album']);
        });
        Schema::table('photos_comments', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
            $table->dropForeign(['account_id']);
        });
        Schema::table('photos_favorites', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
            $table->dropForeign(['account_id']);
        });
        Schema::table('pricing_rules_levels', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['parent_product']);
            $table->dropForeign(['details_img_id']);
            $table->dropForeign(['category_img_id']);
            $table->dropForeign(['default_distributor_id']);
        });
        Schema::table('products_accessories', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['accessory_id']);
        });
        Schema::table('products_accessories_fields', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['accessories_fields_id']);
        });
        Schema::table('products_attributes', function (Blueprint $table) {
            $table->dropForeign(['option_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_details', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['default_category_id']);
        });
        Schema::table('products_distributors', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_images', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_log', function (Blueprint $table) {
            $table->dropForeign(['productdistributor_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_needschildren', function (Blueprint $table) {
            $table->dropForeign(['option_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_options', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_options_custom', function (Blueprint $table) {
            $table->dropForeign(['value_id']);
        });
        Schema::table('products_options_values', function (Blueprint $table) {
            $table->dropForeign(['option_id']);
            $table->dropForeign(['image_id']);
        });
        Schema::table('products_pricing', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['pricing_rule_id']);
            $table->dropForeign(['ordering_rule_id']);
        });
        Schema::table('products_pricing_temp', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['site_id']);
            $table->dropForeign(['pricing_rule_id']);
            $table->dropForeign(['ordering_rule_id']);
        });
        Schema::table('products_related', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['related_id']);
        });
        Schema::table('products_resort', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_reviews', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });
        Schema::table('products_rules_fulfillment_conditions_items', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
        });
        Schema::table('products_rules_fulfillment_distributors', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
            $table->dropForeign(['distributor_id']);
        });
        Schema::table('products_rules_fulfillment_conditions', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
        });
        Schema::table('products_rules_fulfillment_rules', function (Blueprint $table) {
            $table->dropForeign(['parent_rule_id']);
            $table->dropForeign(['child_rule_id']);
        });
        Schema::table('products_rules_ordering_conditions', function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
        });
        Schema::table('products_rules_ordering_conditions_items', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
        });
        Schema::table('products_rules_ordering_rules', function (Blueprint $table) {
            $table->dropForeign(['parent_rule_id']);
            $table->dropForeign(['child_rule_id']);
        });
        Schema::table('products_settings', function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['layout_id']);
            $table->dropForeign(['module_template_id']);
        });
        Schema::table('products_settings_sites', function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['layout_id']);
            $table->dropForeign(['module_template_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('products_settings_sites_modulevalues', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['module_id']);
            $table->dropForeign(['field_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('products_settings_templates', function (Blueprint $table) {
            $table->dropForeign(['settings_template_id']);
            $table->dropForeign(['layout_id']);
            $table->dropForeign(['module_template_id']);
        });
        Schema::table('products_settings_templates_modulevalues', function (Blueprint $table) {
            $table->dropForeign('category_setting_template_id');
            $table->dropForeign(['section_id']);
            $table->dropForeign(['module_id']);
            $table->dropForeign(['field_id']);
        });
        Schema::table('products_specialties', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['specialty_id']);
        });
        Schema::table('products_specialties_check', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_tasks', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        Schema::table('products_types_attributes_sets', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['set_id']);
        });
        Schema::table('products_viewed', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('saved_cart', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
        });
        Schema::table('saved_cart_discounts', function (Blueprint $table) {
            $table->dropForeign(['saved_cart_id']);
        });
        Schema::table('saved_cart_items', function (Blueprint $table) {
            $table->dropForeign(['saved_cart_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['parent_product']);
            $table->dropForeign(['registry_item_id']);
            $table->dropForeign(['accessory_field_id']);
            $table->dropForeign(['distributor_id']);
        });
        Schema::table('saved_cart_items_customfields', function (Blueprint $table) {
            $table->dropForeign(['saved_cart_item_id']);
            $table->dropForeign(['field_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['form_id']);
        });
        Schema::table('saved_cart_items_options', function (Blueprint $table) {
            $table->dropForeign(['saved_cart_item_id']);
        });
        Schema::table('saved_cart_items_options_customvalues', function (Blueprint $table) {
            $table->dropForeign(['saved_cart_item_id']);
            $table->dropForeign(['option_id']);
        });
        Schema::table('saved_order', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['saved_cart_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('saved_order_discounts', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['discount_id']);
        });
        Schema::table('saved_order_information', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['account_billing_id']);
            $table->dropForeign(['account_shipping_id']);
            $table->dropForeign(['bill_state_id']);
            $table->dropForeign(['bill_country_id']);
            $table->dropForeign(['ship_state_id']);
            $table->dropForeign(['ship_country_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['shipping_method_id']);
        });
        Schema::table('search_forms_fields', function (Blueprint $table) {
            $table->dropForeign(['search_id']);
        });
        Schema::table('search_forms_sections', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
        });
        Schema::table('search_forms_sections_fields', function (Blueprint $table) {
            $table->dropForeign(['field_id']);
        });
        Schema::table('shipping_carriers', function (Blueprint $table) {
            $table->dropForeign(['gateway_id']);
        });
        Schema::table('shipping_carriers_shipto', function (Blueprint $table) {
            $table->dropForeign(['shipping_carriers_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::table('shipping_label_sizes', function (Blueprint $table) {
            $table->dropForeign(['gateway_id']);
        });
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->dropForeign(['carrier_id']);
        });
        Schema::table('shipping_package_types', function (Blueprint $table) {
            $table->dropForeign(['carrier_id']);
        });
        Schema::table('shipping_signature_options', function (Blueprint $table) {
            $table->dropForeign(['carrier_id']);
        });
        Schema::table('sites_categories', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::table('sites_currencies', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['currency_id']);
        });
        Schema::table('sites_inventory_rules', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['rule_id']);
        });
        Schema::table('sites_languages', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['language_id']);
        });
        Schema::table('sites_message_templates', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
        });
        Schema::table('sites_packingslip', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
        });
        Schema::table('sites_payment_methods', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['gateway_account_id']);
            $table->dropForeign(['site_id']);
        });
        Schema::table('sites_settings', function (Blueprint $table) {
            $table->dropForeign(['default_layout_id']);
            $table->dropForeign(['search_layout_id']);
            $table->dropForeign(['home_layout_id']);
            $table->dropForeign(['default_category_layout_id']);
            $table->dropForeign(['default_product_layout_id']);
            $table->dropForeign(['account_layout_id']);
            $table->dropForeign(['cart_layout_id']);
            $table->dropForeign(['checkout_layout_id']);
            $table->dropForeign(['page_layout_id']);
            $table->dropForeign(['affiliate_layout_id']);
            $table->dropForeign(['wishlist_layout_id']);
            $table->dropForeign(['default_module_template_id']);
            $table->dropForeign(['default_category_module_template_id']);
            $table->dropForeign(['default_product_module_template_id']);
            $table->dropForeign(['home_module_template_id']);
            $table->dropForeign(['account_module_template_id']);
            $table->dropForeign(['search_module_template_id']);
            $table->dropForeign(['cart_module_template_id']);
            $table->dropForeign(['checkout_module_template_id']);
            $table->dropForeign(['page_module_template_id']);
            $table->dropForeign(['affiliate_module_template_id']);
            $table->dropForeign(['wishlist_module_template_id']);
            $table->dropForeign(['catalog_layout_id']);
            $table->dropForeign(['catalog_module_template_id']);
            $table->dropForeign(['offline_layout_id']);
            $table->dropForeign(['default_category_search_form_id']);
        });
        Schema::table('sites_settings_modulevalues', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['module_id']);
            $table->dropForeign(['field_id']);
        });
        Schema::table('sites_tax_rules', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['tax_rule_id']);
        });
        Schema::table('sites_themes', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['theme_id']);
        });
        Schema::table('tax_rules_locations', function (Blueprint $table) {
            $table->dropForeign(['tax_rule_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
        });
        Schema::table('tax_rules_product_types', function (Blueprint $table) {
            $table->dropForeign(['tax_rule_id']);
            $table->dropForeign(['type_id']);
        });
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
        });
        Schema::table('wishlists_items', function (Blueprint $table) {
            $table->dropForeign(['wishlist_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['parent_product']);
            $table->dropForeign(['parent_wishlist_items_id']);
            $table->dropForeign(['accessory_field_id']);
        });
        Schema::table('wishlists_items_customfields', function (Blueprint $table) {
            $table->dropForeign(['wishlists_item_id']);
            $table->dropForeign(['form_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['field_id']);
        });
        Schema::table('wishlists_items_options', function (Blueprint $table) {
            $table->dropForeign(['wishlists_item_id']);
        });
        Schema::table('wishlists_items_options_customvalues', function (Blueprint $table) {
            $table->dropForeign(['wishlists_item_id']);
            $table->dropForeign(['option_id']);
        });
        Schema::rename('discounts_old', 'discounts');
    }
};
