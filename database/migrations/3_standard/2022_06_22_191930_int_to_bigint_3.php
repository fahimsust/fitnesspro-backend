<?php

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
        Schema::table('board_categories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('board_id')->change();
        });
        Schema::table('sites', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('orders_notes', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('message_templates', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_resort_dates', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('resorts', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('board_thread_entry', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('thread_id')->change();
            $table->unsignedBigInteger('createdby')->change();
        });
        Schema::table('board_threads', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('createdby')->change();
            $table->unsignedBigInteger('updatedby')->change();
            $table->unsignedBigInteger('lastposter')->change();
            $table->unsignedBigInteger('photo')->change();
        });
        Schema::table('board_threads_details', function (Blueprint $table) {
            $table->unsignedBigInteger('thread_id')->change();
        });
        Schema::table('board_type', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('boards', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('group_id')->change();
        });
        Schema::table('bookingas', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('bookingas_options', function (Blueprint $table) {
            $table->unsignedBigInteger('bookingas_id')->change();
        });
        Schema::table('bookingas_products', function (Blueprint $table) {
            $table->unsignedBigInteger('bookingas_id')->change();
            $table->unsignedBigInteger('product')->change();
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('bulkedit_change', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('bulkedit_change_products', function (Blueprint $table) {
            $table->unsignedBigInteger('change_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('catalog_updates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('item_id')->change();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_id')->nullable()->change();
            //$table->unsignedBigInteger('inventory_id')->change();
            $table->unsignedBigInteger('image_id')->change();
        });
//        Schema::table('categories_attributes', function (Blueprint $table) {
//            $table->unsignedBigInteger('category_id')->change();
//            $table->unsignedBigInteger('option_id')->change();
//        });
//        Schema::table('categories_attributes_rules', function (Blueprint $table) {
//            $table->id()->change();
//            $table->unsignedBigInteger('category_id')->change();
//            $table->unsignedBigInteger('temp_id')->change();
//            $table->unsignedBigInteger('value_id')->change();
//        });
        Schema::table('categories_brands', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('brand_id')->change();
        });
        Schema::table('categories_featured', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('categories_products_assn', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('categories_products_hide', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('categories_products_ranks', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('categories_products_sorts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('sort_id')->change();
        });
        Schema::table('categories_rules', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('temp_id')->change();
        });
        Schema::table('categories_rules_attributes', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('set_id')->change();
            $table->unsignedBigInteger('rule_id')->nullable()->change();
            $table->unsignedBigInteger('value_id')->nullable()->change();
        });
        Schema::table('categories_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
        });
        Schema::table('categories_settings_sites', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
            $table->unsignedBigInteger('search_form_id')->nullable()->change();
        });
        Schema::table('categories_settings_sites_modulevalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('module_id')->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('categories_settings_templates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
            $table->unsignedBigInteger('search_form_id')->nullable()->change();
        });
        Schema::table('categories_settings_templates_modulevalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('settings_template_id')->change();
            $table->unsignedBigInteger('module_id')->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('categories_types', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('type_id')->change();
        });
        Schema::table('cim_profile', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_account_id')->change();
        });
        Schema::table('cim_profile_paymentprofile', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('profile_id')->nullable()->change();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('countries_regions', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('currencies', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('custom_fields', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('custom_forms', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('custom_forms_sections', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('form_id')->change();
        });
        Schema::table('custom_forms_sections_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('custom_forms_show', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id')->change();
        });
        Schema::table('custom_forms_show_products', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('custom_forms_show_producttypes', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id')->change();
            $table->unsignedBigInteger('product_type_id')->change();
        });
        Schema::table('discount', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('discount_advantage', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('discount_id')->change();
            $table->unsignedBigInteger('advantage_type_id')->change();
            $table->unsignedBigInteger('apply_shipping_id')->nullable()->change();
            $table->unsignedBigInteger('apply_shipping_country')->nullable()->change();
            $table->unsignedBigInteger('apply_shipping_distributor')->nullable()->change();
        });
        Schema::table('discount_advantage_products', function (Blueprint $table) {
            $table->unsignedBigInteger('advantage_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('discount_advantage_producttypes', function (Blueprint $table) {
            $table->unsignedBigInteger('advantage_id')->nullable()->change();
            $table->unsignedBigInteger('producttype_id')->change();
        });
        Schema::table('discount_advantage_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('discount_rule', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('discount_id')->change();
        });
        Schema::table('discount_rule_condition', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('rule_id')->change();
            $table->unsignedBigInteger('condition_type_id')->change();
        });
        Schema::table('discount_rule_condition_accounttypes', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('accounttype_id')->change();
        });
        Schema::table('discount_rule_condition_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('attributevalue_id')->change();
        });
        Schema::table('discount_rule_condition_countries', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('discount_rule_condition_distributors', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('distributor_id')->change();
        });
        Schema::table('discount_rule_condition_membershiplevels', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->nullable()->change();
            $table->unsignedBigInteger('membershiplevel_id')->change();
        });
        Schema::table('discount_rule_condition_onsalestatuses', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('onsalestatus_id')->change();
        });
        Schema::table('discount_rule_condition_outofstockstatuses', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('outofstockstatus_id')->change();
        });
        Schema::table('discount_rule_condition_productavailabilities', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('availability_id')->change();
        });
        Schema::table('discount_rule_condition_products', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('discount_rule_condition_producttypes', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('producttype_id')->change();
        });
        Schema::table('discount_rule_condition_sites', function (Blueprint $table) {
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('discount_rule_condition_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('discounts_advantages', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('discount_id')->change();
            $table->unsignedBigInteger('advantage_type_id')->change();
            $table->unsignedBigInteger('apply_shipping_id')->change();
        });
        Schema::table('discounts_advantages_products', function (Blueprint $table) {
            $table->unsignedBigInteger('advantage_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('discounts_levels', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('discounts_levels_products', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('discount_level_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('discounts_rules', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('discount_id')->change();
            $table->unsignedBigInteger('rule_type_id')->change();
        });
        Schema::table('discounts_rules_products', function (Blueprint $table) {
            $table->unsignedBigInteger('rule_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('display_layouts', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('display_sections', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('display_templates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('type_id')->change();
        });
        Schema::table('display_templates_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('display_themes', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('distributors', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('inventory_account_id')->change();
        });
        Schema::table('distributors_availabilities', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('availability_id')->change();
        });
        Schema::table('distributors_canadapost', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('state_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('distributors_endicia', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('state_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('distributors_fedex', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('state_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('distributors_genericshipping', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('state_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('distributors_shipping_flatrates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('distributor_shippingmethod_id')->change();
            $table->unsignedBigInteger('shipto_country')->change();
        });
        Schema::table('distributors_shipping_gateways', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('shipping_gateway_id')->change();
        });
        Schema::table('distributors_shipping_methods', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('shipping_method_id')->change();
        });
        Schema::table('distributors_shipstation', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('state_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('distributors_ups', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('state_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('distributors_usps', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('state_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('elements', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('createdby')->change();
            $table->unsignedBigInteger('photo')->nullable()->change();
            $table->unsignedBigInteger('type_id')->change();
        });
        Schema::table('events_toattend', function (Blueprint $table) {
            $table->unsignedBigInteger('userid')->change();
            $table->unsignedBigInteger('eventid')->change();
        });
        Schema::table('events_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('events_views', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->change();
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('faqs', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('faqs_categories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('faqs_id')->change();
            $table->unsignedBigInteger('categories_id')->change();
        });
        Schema::table('faqs_categories_translations', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('categories_id')->change();
            $table->unsignedBigInteger('language_id')->change();
        });
        Schema::table('faqs_translations', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('faqs_id')->change();
            $table->unsignedBigInteger('language_id')->change();
        });
        Schema::table('files', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('filters', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('filters_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_id')->change();
            $table->unsignedBigInteger('filter_id')->change();
        });
        Schema::table('filters_availabilities', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('filter_id')->change();
        });
        Schema::table('filters_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('filter_id')->change();
        });
        Schema::table('filters_pricing', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('filter_id')->change();
        });
        Schema::table('filters_productoptions', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('filter_id')->change();
        });
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('friend_id')->nullable()->change();
        });
        Schema::table('friends', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('friend_id')->nullable()->change();
        });
        Schema::table('friends_updates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('friend_id')->nullable()->change();
        });
        Schema::table('friends_updates_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('gift_cards_transactions', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('giftcard_id')->change();
            $table->unsignedBigInteger('admin_user_id')->nullable()->change();
            $table->unsignedBigInteger('order_id')->nullable()->change();
        });
        Schema::table('giftregistry', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('shipto_id')->change();
        });
        Schema::table('giftregistry_genders', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('giftregistry_items', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('registry_id')->change();
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('parent_product')->nullable()->change();
        });
        Schema::table('giftregistry_items_purchased', function (Blueprint $table) {
            $table->unsignedBigInteger('registry_item_id')->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('order_product_id')->change();
        });
        Schema::table('giftregistry_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('group_bulletins', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('group_id')->change();
            $table->unsignedBigInteger('createdby')->change();
        });
        Schema::table('group_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->change();
            $table->unsignedBigInteger('user_id')->change();
        });
        Schema::table('group_updates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('group_id')->change();
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('friend_id')->change();
        });
        Schema::table('group_users', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->change();
            $table->unsignedBigInteger('user_id')->change();
        });
        Schema::table('groups', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('admin_user')->change();
            $table->unsignedBigInteger('photo')->change();
        });
        Schema::table('help_pops', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('images', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('images_sizes', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('instructors_certfiles', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('inventory_gateways', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('inventory_gateways_accounts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_id')->change();
            $table->unsignedBigInteger('last_load_id')->change();
            $table->unsignedBigInteger('distributor_id')->change();
            $table->unsignedBigInteger('base_currency')->change();
        });
        Schema::table('inventory_gateways_fields', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_id')->change();
        });
        Schema::table('inventory_gateways_orders', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_account_id')->change();
            $table->unsignedBigInteger('shipment_id')->change();
        });
        Schema::table('inventory_gateways_scheduledtasks', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_account_id')->change();
        });
        Schema::table('inventory_gateways_scheduledtasks_products', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('task_id')->change();
            $table->unsignedBigInteger('products_id')->change();
            $table->unsignedBigInteger('products_distributors_id')->change();
        });
        Schema::table('inventory_gateways_sites', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_account_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('inventory_rules', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('languages', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('languages_content', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('languages_translations', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('content_id')->change();
            $table->unsignedBigInteger('language_id')->change();
        });
        Schema::table('loyaltypoints', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('active_level_id')->change();
        });
        Schema::table('loyaltypoints_levels', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('loyaltypoints_id')->change();
        });
        Schema::table('menu', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent')->nullable()->change();
        });
        Schema::table('menu_links', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('menus_catalogcategories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('category_id')->change();
        });
        Schema::table('menus_categories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('category_id')->change();
        });
        Schema::table('menus_links', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('links_id')->change();
        });
        Schema::table('menus_menus', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('child_menu_id')->change();
        });
        Schema::table('menus_pages', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('page_id')->change();
            $table->unsignedBigInteger('sub_pagemenu_id')->change();
            $table->unsignedBigInteger('sub_categorymenu_id')->change();
        });
        Schema::table('menus_sites', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('message_templates_new', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('mod_resort_details_amenities', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('mods_account_ads', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('mods_account_ads_campaigns', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('mods_account_ads_clicks', function (Blueprint $table) {
            $table->unsignedBigInteger('ad_id')->nullable()->change();
        });
        Schema::table('mods_account_certifications', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
        });
        Schema::table('mods_account_certifications_files', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('certification_id')->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
        });
        Schema::table('mods_account_files', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('mods_dates_auto_orderrules', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('mods_dates_auto_orderrules_action', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('dao_id')->change();
            $table->unsignedBigInteger('criteria_orderingruleid')->nullable()->change();
            $table->unsignedBigInteger('criteria_siteid')->nullable()->change();
            $table->unsignedBigInteger('changeto_orderingruleid')->change();
        });
        Schema::table('mods_dates_auto_orderrules_excludes', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('dao_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('mods_dates_auto_orderrules_products', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('dao_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('mods_lookbooks', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('mods_lookbooks_areas', function (Blueprint $table) {
            $table->unsignedBigInteger('area_id')->change();
            $table->unsignedBigInteger('lookbook_id')->change();
        });
        Schema::table('mods_lookbooks_areas_images', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('temp_id')->change();
            $table->unsignedBigInteger('lookbook_id')->change();
            $table->unsignedBigInteger('area_id')->change();
            $table->unsignedBigInteger('image_id')->change();
        });
        Schema::table('mods_lookbooks_images', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('mods_lookbooks_images_maps', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('eimage_id')->change();
        });
        // Schema::table('mods_pages_viewed', function (Blueprint $table) {
        //     $table->id()->change();
        //     $table->unsignedBigInteger('account_id')->change();
        //     $table->unsignedBigInteger('page_id')->change();
        // });
        Schema::table('mods_resort_details', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_option_id')->change();
            $table->unsignedBigInteger('contact_state_id')->change();
            $table->unsignedBigInteger('contact_country_id')->change();
            $table->unsignedBigInteger('region_id')->change();
            $table->unsignedBigInteger('airport_id')->change();
            $table->unsignedBigInteger('fpt_manager_id')->nullable()->change();
        });
        Schema::table('mods_resort_details_amenities', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('resort_details_id')->change();
            $table->unsignedBigInteger('amenity_id')->nullable()->change();
        });
        Schema::table('mods_trip_flyers', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('orders_products_id')->nullable()->change();
            $table->unsignedBigInteger('photo_id')->nullable()->change();
        });
        Schema::table('mods_trip_flyers_settings', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('photo_id')->nullable()->change();
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('modules_admin_controllers', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('module_id')->change();
        });
        Schema::table('modules_crons', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('module_id')->change();
        });
        Schema::table('modules_crons_scheduledtasks', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('modules_fields', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('module_id')->change();
        });
        Schema::table('modules_site_controllers', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('module_id')->change();
        });
        Schema::table('modules_templates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_template_id')->nullable()->change();
        });
        Schema::table('modules_templates_modules', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable()->change();
            $table->unsignedBigInteger('module_id')->nullable()->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('temp_id')->change();
        });
        Schema::table('modules_templates_sections', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable()->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('temp_id')->change();
        });
        Schema::table('newsletters', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('newsletters_history', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('newsletter_id')->change();
        });
        Schema::table('newsletters_sites', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('newsletter_id')->change();
        });
        Schema::table('newsletters_subscribers', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('newsletter_id')->change();
        });
        Schema::table('options_templates', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('options_templates_images', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->change();
            $table->unsignedBigInteger('image_id')->change();
        });
        Schema::table('options_templates_options', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('template_id')->nullable()->change();
        });
        Schema::table('options_templates_options_custom', function (Blueprint $table) {
            $table->unsignedBigInteger('value_id')->change();
        });
        Schema::table('options_templates_options_values', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('option_id')->change();
            $table->unsignedBigInteger('image_id')->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('account_billing_id')->nullable()->change();
            $table->unsignedBigInteger('account_shipping_id')->nullable()->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('orders_activities', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->change();
            $table->unsignedBigInteger('user_id')->change();
        });
        Schema::table('orders_billing', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('bill_state_id')->nullable()->change();
            $table->unsignedBigInteger('bill_country_id')->nullable()->change();
        });
        Schema::table('orders_customforms', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('form_id')->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('product_type_id')->nullable()->change();
        });
        Schema::table('orders_discounts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('discount_id')->nullable()->change();
            $table->unsignedBigInteger('advantage_id')->nullable()->change();
        });
        Schema::table('orders_packages', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('shipment_id')->nullable()->change();
        });
        Schema::table('orders_products', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('actual_product_id')->change();
            $table->unsignedBigInteger('package_id')->change();
            $table->unsignedBigInteger('parent_product_id')->nullable()->change();
            $table->unsignedBigInteger('cart_id')->change();
            $table->unsignedBigInteger('registry_item_id')->nullable()->change();
        });
        Schema::table('orders_products_customfields', function (Blueprint $table) {
            $table->unsignedBigInteger('orders_products_id')->change();
            $table->unsignedBigInteger('form_id')->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('orders_products_customsinfo', function (Blueprint $table) {
            $table->unsignedBigInteger('orders_products_id')->change();
        });
        Schema::table('orders_products_discounts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('orders_products_id')->change();
            $table->unsignedBigInteger('discount_id')->nullable()->change();
            $table->unsignedBigInteger('advantage_id')->nullable()->change();
        });
        Schema::table('orders_products_options', function (Blueprint $table) {
            $table->unsignedBigInteger('orders_products_id')->nullable()->change();
            $table->unsignedBigInteger('value_id')->nullable()->change();
        });
        Schema::table('orders_products_sentemails', function (Blueprint $table) {
            $table->unsignedBigInteger('op_id')->nullable()->change();
            $table->unsignedBigInteger('email_id')->change();
        });
        Schema::table('orders_shipments', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('distributor_id')->nullable()->change();
            $table->unsignedBigInteger('ship_method_id')->nullable()->change();
            $table->unsignedBigInteger('order_status_id')->nullable()->change();
        });
        Schema::table('orders_shipments_labels', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('shipment_id')->change();
            $table->unsignedBigInteger('package_id')->change();
            $table->unsignedBigInteger('label_size_id')->change();
        });
        Schema::table('orders_shipping', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('ship_state_id')->nullable()->change();
            $table->unsignedBigInteger('ship_country_id')->nullable()->change();
        });
        Schema::table('orders_statuses', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('orders_tasks', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->change();
        });
        Schema::table('orders_transactions', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->nullable()->change();
            $table->unsignedBigInteger('account_billing_id')->nullable()->change();
            $table->unsignedBigInteger('payment_method_id')->change();
            $table->unsignedBigInteger('gateway_account_id')->nullable()->change();
            $table->unsignedBigInteger('cim_payment_profile_id')->nullable()->change();
        });
        Schema::table('orders_transactions_billing', function (Blueprint $table) {
            $table->unsignedBigInteger('orders_transactions_id')->change();
            $table->unsignedBigInteger('bill_state_id')->nullable()->change();
            $table->unsignedBigInteger('bill_country_id')->nullable()->change();
        });
        Schema::table('orders_transactions_credits', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('orders_transactions_id')->change();
        });
        Schema::table('orders_transactions_statuses', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('pages_categories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_category_id')->nullable()->change();
        });
        Schema::table('pages_categories_pages', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('page_id')->change();
        });
        Schema::table('pages_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
            $table->unsignedBigInteger('page_id')->change();
        });
        Schema::table('pages_settings_sites', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('page_id')->nullable()->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
        });
        Schema::table('pages_settings_sites_modulevalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('page_id')->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('module_id')->change();
            $table->unsignedBigInteger('field_id')->nullable()->change();
        });
        Schema::table('pages_settings_templates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
        });
        Schema::table('pages_settings_templates_modulevalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('settings_template_id')->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('module_id')->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('payment_gateways_accounts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_id')->change();
        });
        Schema::table('payment_gateways_accounts_limitcountries', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_account_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('payment_gateways_errors', function (Blueprint $table) {
            $table->unsignedBigInteger('gateway_account_id')->change();
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_id')->nullable()->change();
        });
        Schema::table('payment_methods_limitcountries', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('payment_method_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('photos', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('addedby')->nullable()->change();
            $table->unsignedBigInteger('album')->nullable()->change();
        });
        Schema::table('photos_albums', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('recent_photo_id')->change();
        });
        Schema::table('photos_albums_type', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('photos_comments', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('photo_id')->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
        });
        Schema::table('photos_favorites', function (Blueprint $table) {
            $table->unsignedBigInteger('photo_id')->nullable()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
        });
        Schema::table('photos_sizes', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('pricing_rules', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('pricing_rules_levels', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('rule_id')->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_product')->nullable()->change();
            $table->unsignedBigInteger('default_outofstockstatus_id')->nullable()->change();
            $table->unsignedBigInteger('details_img_id')->nullable()->change();
            $table->unsignedBigInteger('category_img_id')->nullable()->change();
            $table->unsignedBigInteger('default_distributor_id')->nullable()->change();
            $table->unsignedBigInteger('fulfillment_rule_id')->nullable()->change();
        });
        Schema::table('products_accessories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('accessory_id')->change();
        });
        Schema::table('products_accessories_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('accessories_fields_id')->change();
        });
        Schema::table('products_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('option_id')->nullable()->change();
        });
        Schema::table('products_availability', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_children_options', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('option_id')->change();
        });
        Schema::table('products_details', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('type_id')->nullable()->change();
            $table->unsignedBigInteger('brand_id')->nullable()->change();
            $table->unsignedBigInteger('default_category_id')->nullable()->change();
        });
        Schema::table('products_distributors', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('distributor_id')->nullable()->change();
        });
        Schema::table('products_images', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('image_id')->change();
        });
        Schema::table('products_log', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('productdistributor_id')->change();
        });
        Schema::table('products_needschildren', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('option_id')->change();
        });
        Schema::table('products_options', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('type_id')->change();
        });
        Schema::table('products_options_custom', function (Blueprint $table) {
            $table->unsignedBigInteger('value_id')->change();
        });
        Schema::table('products_options_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_options_values', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('option_id')->nullable()->change();
            $table->unsignedBigInteger('image_id')->nullable()->change();
        });
        Schema::table('products_pricing', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('pricing_rule_id')->nullable()->change();
            $table->unsignedBigInteger('ordering_rule_id')->nullable()->change();
        });
        Schema::table('products_pricing_temp', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('pricing_rule_id')->nullable()->change();
            $table->unsignedBigInteger('ordering_rule_id')->nullable()->change();
        });
        Schema::table('products_related', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('related_id')->change();
        });
        Schema::table('products_resort', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('resort_id')->change();
        });
        Schema::table('products_reviews', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('item_id')->change();
        });
        Schema::table('products_rules_fulfillment', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_rules_fulfillment_conditions', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('rule_id')->change();
        });
        Schema::table('products_rules_fulfillment_conditions_items', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('item_id')->change();
        });
        Schema::table('products_rules_fulfillment_distributors', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('rule_id')->change();
            $table->unsignedBigInteger('distributor_id')->change();
        });
        Schema::table('products_rules_fulfillment_rules', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_rule_id')->nullable()->change();
            $table->unsignedBigInteger('child_rule_id')->change();
        });
        Schema::table('products_rules_ordering', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_rules_ordering_conditions', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('rule_id')->nullable()->change();
        });
        Schema::table('products_rules_ordering_conditions_items', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('condition_id')->change();
            $table->unsignedBigInteger('item_id')->change();
        });
        Schema::table('products_rules_ordering_rules', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_rule_id')->nullable()->change();
            $table->unsignedBigInteger('child_rule_id')->change();
        });
        Schema::table('products_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
        });
        Schema::table('products_settings_sites', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
        });
        Schema::table('products_settings_sites_modulevalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('module_id')->change();
            $table->unsignedBigInteger('field_id')->nullable()->change();
        });
        Schema::table('products_settings_templates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('settings_template_id')->nullable()->change();
            $table->unsignedBigInteger('layout_id')->nullable()->change();
            $table->unsignedBigInteger('module_template_id')->nullable()->change();
        });
        Schema::table('products_settings_templates_modulevalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('settings_template_id')->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('module_id')->change();
            $table->unsignedBigInteger('field_id')->nullable()->change();
        });
        Schema::table('products_sorts', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_specialties', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('specialty_id')->change();
        });
        Schema::table('products_specialties_check', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('products_specialtiesaccountsrules', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('rule_id')->change();
        });
        Schema::table('products_tasks', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('products_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_types_attributes_sets', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('set_id')->nullable()->change();
        });
        Schema::table('products_viewed', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('reports_breakdowns', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('reports_products_fields', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('reports_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('resorts_amenities', function (Blueprint $table) {
            $table->unsignedBigInteger('resort_id')->change();
            $table->unsignedBigInteger('amenity_id')->change();
        });
        Schema::table('saved_cart', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
        });
        Schema::table('saved_cart_discounts', function (Blueprint $table) {
            $table->unsignedBigInteger('saved_cart_id')->change();
        });
        Schema::table('saved_cart_items', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('saved_cart_id')->change();
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('cart_id')->change();
            $table->unsignedBigInteger('parent_product')->nullable()->change();
            $table->unsignedBigInteger('parent_cart_id')->nullable()->change();
            $table->unsignedBigInteger('registry_item_id')->nullable()->change();
            $table->unsignedBigInteger('accessory_field_id')->nullable()->change();
            $table->unsignedBigInteger('distributor_id')->nullable()->change();
        });
        Schema::table('saved_cart_items_customfields', function (Blueprint $table) {
            $table->unsignedBigInteger('saved_cart_item_id')->change();
            $table->unsignedBigInteger('form_id')->nullable()->change();
            $table->unsignedBigInteger('section_id')->nullable()->change();
            $table->unsignedBigInteger('field_id')->nullable()->change();
        });
        Schema::table('saved_cart_items_options', function (Blueprint $table) {
            $table->unsignedBigInteger('saved_cart_item_id')->change();
        });
        Schema::table('saved_cart_items_options_customvalues', function (Blueprint $table) {
            $table->unsignedBigInteger('saved_cart_item_id')->change();
            $table->unsignedBigInteger('option_id')->change();
        });
        Schema::table('saved_order', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('saved_cart_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('saved_order_discounts', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('discount_id')->change();
        });
        Schema::table('saved_order_information', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('account_billing_id')->nullable()->change();
            $table->unsignedBigInteger('account_shipping_id')->nullable()->change();
            $table->unsignedBigInteger('bill_state_id')->nullable()->change();
            $table->unsignedBigInteger('bill_country_id')->nullable()->change();
            $table->unsignedBigInteger('ship_state_id')->nullable()->change();
            $table->unsignedBigInteger('ship_country_id')->nullable()->change();
            $table->unsignedBigInteger('payment_method_id')->nullable()->change();
            $table->unsignedBigInteger('shipping_method_id')->nullable()->change();
        });
        Schema::table('search_forms', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('search_forms_fields', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('search_id')->nullable()->change();
        });
        Schema::table('search_forms_sections', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('form_id')->change();
        });
        Schema::table('search_forms_sections_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('shipping_carriers', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_id')->nullable()->change();
        });
        Schema::table('shipping_carriers_shipto', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('shipping_carriers_id')->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('shipping_gateways', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('shipping_label_sizes', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('gateway_id')->change();
        });
        Schema::table('shipping_label_templates', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('carrier_id')->change();
        });
        Schema::table('shipping_package_sizes', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('shipping_package_types', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('carrier_id')->change();
        });
        Schema::table('shipping_signature_options', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('carrier_id')->change();
        });
        Schema::table('sites_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('category_id')->change();
        });
        Schema::table('sites_currencies', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('currency_id')->change();
        });
        Schema::table('sites_datafeeds', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('datafeed_id')->change();
        });
        Schema::table('sites_inventory_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('rule_id')->change();
        });
        Schema::table('sites_languages', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('language_id')->change();
        });
        Schema::table('sites_message_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('sites_packingslip', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('sites_payment_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('payment_method_id')->change();
            $table->unsignedBigInteger('gateway_account_id')->nullable()->change();
        });
        Schema::table('sites_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('default_layout_id')->change();
            $table->unsignedBigInteger('search_layout_id')->change();
            $table->unsignedBigInteger('home_layout_id')->change();
            $table->unsignedBigInteger('default_category_layout_id')->change();
            $table->unsignedBigInteger('default_product_layout_id')->change();
            $table->unsignedBigInteger('account_layout_id')->change();
            $table->unsignedBigInteger('cart_layout_id')->change();
            $table->unsignedBigInteger('checkout_layout_id')->change();
            $table->unsignedBigInteger('page_layout_id')->change();
            $table->unsignedBigInteger('affiliate_layout_id')->change();
            $table->unsignedBigInteger('wishlist_layout_id')->change();
            $table->unsignedBigInteger('default_module_template_id')->change();
            $table->unsignedBigInteger('default_category_module_template_id')->change();
            $table->unsignedBigInteger('home_module_template_id')->change();
            $table->unsignedBigInteger('default_product_module_template_id')->change();
            $table->unsignedBigInteger('account_module_template_id')->change();
            $table->unsignedBigInteger('search_module_template_id')->change();
            $table->unsignedBigInteger('cart_module_template_id')->change();
            $table->unsignedBigInteger('checkout_module_template_id')->change();
            $table->unsignedBigInteger('page_module_template_id')->change();
            $table->unsignedBigInteger('affiliate_module_template_id')->change();
            $table->unsignedBigInteger('wishlist_module_template_id')->change();
            $table->unsignedBigInteger('catalog_layout_id')->change();
            $table->unsignedBigInteger('catalog_module_template_id')->change();
            $table->unsignedBigInteger('offline_layout_id')->change();
            $table->unsignedBigInteger('default_category_search_form_id')->nullable()->change();
        });
        Schema::table('sites_settings_modulevalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('module_id')->change();
            $table->unsignedBigInteger('field_id')->nullable()->change();
        });
        Schema::table('sites_tax_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->change();
            $table->unsignedBigInteger('tax_rule_id')->nullable()->change();
        });
        Schema::table('sites_themes', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('theme_id')->change();
        });
        Schema::table('states', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('country_id')->change();
        });
        Schema::table('system', function (Blueprint $table) {
            $table->unsignedBigInteger('giftcard_template_id')->change();
            $table->unsignedBigInteger('giftcard_waccount_template_id')->change();
        });
        Schema::table('system_alerts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('reference_id')->change();
        });
        Schema::table('system_errors', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent')->nullable()->change();
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('type_subid')->change();
        });
        Schema::table('system_messages', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('system_tasks', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('system_updates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('tax_rules', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('tax_rules_locations', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('tax_rule_id')->nullable()->change();
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('state_id')->change();
        });
        Schema::table('tax_rules_product_types', function (Blueprint $table) {
            $table->unsignedBigInteger('tax_rule_id')->nullable()->change();
            $table->unsignedBigInteger('type_id')->change();
        });
        Schema::table('wishlists', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('wishlists_items', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('wishlist_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('parent_product')->nullable()->change();
            $table->unsignedBigInteger('parent_wishlist_items_id')->nullable()->change();
            $table->unsignedBigInteger('accessory_field_id')->nullable()->change();
        });
        Schema::table('wishlists_items_customfields', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('wishlists_item_id')->change();
            $table->unsignedBigInteger('form_id')->change();
            $table->unsignedBigInteger('section_id')->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('wishlists_items_options', function (Blueprint $table) {
            $table->unsignedBigInteger('wishlists_item_id')->change();
        });
        Schema::table('wishlists_items_options_customvalues', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('wishlists_item_id')->change();
            $table->unsignedBigInteger('option_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('board_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('board_id')->change();
        });
        Schema::table('board_thread_entry', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('thread_id')->change();
            $table->integer('createdby')->change();
        });
        Schema::table('board_threads', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('category_id')->change();
            $table->integer('createdby')->change();
            $table->integer('updatedby')->change();
            $table->integer('lastposter')->change();
            $table->integer('photo')->change();
        });
        Schema::table('board_threads_details', function (Blueprint $table) {
            $table->integer('thread_id')->change();
        });
        Schema::table('board_type', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('boards', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('group_id')->change();
        });
        Schema::table('bookingas', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('bookingas_options', function (Blueprint $table) {
            $table->integer('bookingas_id')->change();
        });
        Schema::table('bookingas_products', function (Blueprint $table) {
            $table->integer('bookingas_id')->change();
            $table->integer('product')->change();
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('bulkedit_change', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('bulkedit_change_products', function (Blueprint $table) {
            $table->integer('change_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('catalog_updates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('item_id')->change();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent_id')->nullable()->change();
            // $table->integer('inventory_id')->change();
            $table->integer('image_id')->change();
        });
//        Schema::table('categories_attributes', function (Blueprint $table) {
//            $table->integer('category_id')->change();
//            $table->integer('option_id')->change();
//        });
//        Schema::table('categories_attributes_rules', function (Blueprint $table) {
//            $table->integer('id')->autoIncrement()->change();
//            $table->integer('category_id')->change();
//            $table->integer('temp_id')->change();
//            $table->integer('value_id')->change();
//        });
        Schema::table('categories_brands', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->integer('brand_id')->change();
        });
        Schema::table('categories_featured', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('category_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('categories_products_assn', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('categories_products_hide', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('categories_products_ranks', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('categories_products_sorts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('category_id')->change();
            $table->integer('sort_id')->change();
        });
        Schema::table('categories_rules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('category_id')->change();
            $table->integer('temp_id')->change();
        });
        Schema::table('categories_rules_attributes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('set_id')->change();
            $table->integer('rule_id')->change();
            $table->integer('value_id')->change();
        });
        Schema::table('categories_settings', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->integer('settings_template_id')->change();
            $table->integer('layout_id')->change();
            $table->integer('module_template_id')->change();
        });
        Schema::table('categories_settings_sites', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('settings_template_id')->nullable()->change();
            $table->integer('site_id')->change();
            $table->integer('category_id')->change();
            $table->integer('layout_id')->nullable()->change();
            $table->integer('module_template_id')->nullable()->change();
            $table->integer('search_form_id')->nullable()->change();
        });
        Schema::table('categories_settings_sites_modulevalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('section_id')->change();
            $table->integer('site_id')->change();
            $table->integer('category_id')->change();
            $table->integer('module_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('categories_settings_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('settings_template_id')->nullable()->change();
            $table->integer('layout_id')->nullable()->change();
            $table->integer('module_template_id')->nullable()->change();
            $table->integer('search_form_id')->nullable()->change();
        });
        Schema::table('categories_settings_templates_modulevalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('section_id')->change();
            $table->integer('settings_template_id')->change();
            $table->integer('module_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('categories_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('category_id')->change();
            $table->integer('type_id')->change();
        });
        Schema::table('cim_profile', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_account_id')->change();
        });
        Schema::table('cim_profile_paymentprofile', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('profile_id')->change();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('countries_regions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('country_id')->change();
        });
        Schema::table('currencies', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('custom_fields', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('custom_forms', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('custom_forms_sections', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('form_id')->change();
        });
        Schema::table('custom_forms_sections_fields', function (Blueprint $table) {
            $table->integer('section_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('custom_forms_show', function (Blueprint $table) {
            $table->integer('form_id')->change();
        });
        Schema::table('custom_forms_show_products', function (Blueprint $table) {
            $table->integer('form_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('custom_forms_show_producttypes', function (Blueprint $table) {
            $table->integer('form_id')->change();
            $table->integer('product_type_id')->change();
        });
        Schema::table('discount', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('discount_advantage', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('discount_id')->change();
            $table->integer('advantage_type_id')->change();
            $table->integer('apply_shipping_id')->change();
        });
        Schema::table('discount_advantage_products', function (Blueprint $table) {
            $table->integer('advantage_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('discount_advantage_producttypes', function (Blueprint $table) {
            $table->integer('advantage_id')->change();
            $table->integer('producttype_id')->change();
        });
        Schema::table('discount_advantage_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('discount_rule', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('discount_id')->change();
        });
        Schema::table('discount_rule_condition', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('rule_id')->change();
            $table->integer('condition_type_id')->change();
        });
        Schema::table('discount_rule_condition_accounttypes', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('accounttype_id')->change();
        });
        Schema::table('discount_rule_condition_attributes', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('attributevalue_id')->change();
        });
        Schema::table('discount_rule_condition_countries', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('discount_rule_condition_distributors', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('distributor_id')->change();
        });
        Schema::table('discount_rule_condition_membershiplevels', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('membershiplevel_id')->change();
        });
        Schema::table('discount_rule_condition_onsalestatuses', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('onsalestatus_id')->change();
        });
        Schema::table('discount_rule_condition_outofstockstatuses', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('outofstockstatus_id')->change();
        });
        Schema::table('discount_rule_condition_productavailabilities', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('availability_id')->change();
        });
        Schema::table('discount_rule_condition_products', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('discount_rule_condition_producttypes', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('producttype_id')->change();
        });
        Schema::table('discount_rule_condition_sites', function (Blueprint $table) {
            $table->integer('condition_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('discount_rule_condition_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('discounts_advantages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('discount_id')->change();
            $table->integer('advantage_type_id')->change();
            $table->integer('apply_shipping_id')->change();
        });
        Schema::table('discounts_advantages_products', function (Blueprint $table) {
            $table->integer('advantage_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('discounts_levels', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('discounts_levels_products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('discount_level_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('discounts_rules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('discount_id')->change();
            $table->integer('rule_type_id')->change();
        });
        Schema::table('discounts_rules_products', function (Blueprint $table) {
            $table->integer('rule_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('display_layouts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('display_sections', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('display_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('type_id')->change();
        });
        Schema::table('display_templates_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('display_themes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('distributors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('inventory_account_id')->change();
        });
        Schema::table('distributors_availabilities', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('distributor_id')->change();
            $table->integer('availability_id')->change();
        });
        Schema::table('distributors_canadapost', function (Blueprint $table) {
            $table->integer('distributor_id')->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('distributors_endicia', function (Blueprint $table) {
            $table->integer('distributor_id')->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('distributors_fedex', function (Blueprint $table) {
            $table->integer('distributor_id')->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('distributors_genericshipping', function (Blueprint $table) {
            $table->integer('distributor_id')->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('distributors_shipping_flatrates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('distributor_shippingmethod_id')->change();
            $table->integer('shipto_country')->change();
        });
        Schema::table('distributors_shipping_gateways', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('distributor_id')->change();
            $table->integer('shipping_gateway_id')->change();
        });
        Schema::table('distributors_shipping_methods', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('distributor_id')->change();
            $table->integer('shipping_method_id')->change();
        });
        Schema::table('distributors_shipstation', function (Blueprint $table) {
            $table->integer('distributor_id')->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('distributors_ups', function (Blueprint $table) {
            $table->integer('distributor_id')->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('distributors_usps', function (Blueprint $table) {
            $table->integer('distributor_id')->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('elements', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('createdby')->change();
            $table->integer('photo')->change();
            $table->integer('type_id')->change();
        });
        Schema::table('events_toattend', function (Blueprint $table) {
            $table->integer('userid')->change();
            $table->integer('eventid')->change();
        });
        Schema::table('events_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('events_views', function (Blueprint $table) {
            $table->integer('event_id')->change();
            $table->integer('account_id')->change();
        });
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('faqs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('faqs_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('faqs_id')->change();
            $table->integer('categories_id')->change();
        });
        Schema::table('faqs_categories_translations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('categories_id')->change();
            $table->integer('language_id')->change();
        });
        Schema::table('faqs_translations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('faqs_id')->change();
            $table->integer('language_id')->change();
        });
        Schema::table('files', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('filters', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('filters_attributes', function (Blueprint $table) {
            $table->integer('attribute_id')->change();
            $table->integer('filter_id')->change();
        });
        Schema::table('filters_availabilities', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('filter_id')->change();
        });
        Schema::table('filters_categories', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->integer('filter_id')->change();
        });
        Schema::table('filters_pricing', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('filter_id')->change();
        });
        Schema::table('filters_productoptions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('filter_id')->change();
        });
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('friend_id')->change();
        });
        Schema::table('friends', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('friend_id')->change();
        });
        Schema::table('friends_updates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('type_id')->change();
            $table->integer('friend_id')->change();
        });
        Schema::table('friends_updates_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('gift_cards_transactions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('giftcard_id')->change();
            $table->integer('admin_user_id')->change();
            $table->integer('order_id')->change();
        });
        Schema::table('giftregistry', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('shipto_id')->change();
        });
        Schema::table('giftregistry_genders', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('giftregistry_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('registry_id')->change();
            $table->integer('product_id')->change();
            $table->integer('parent_product')->nullable()->change();
        });
        Schema::table('giftregistry_items_purchased', function (Blueprint $table) {
            $table->integer('registry_item_id')->change();
            $table->integer('account_id')->change();
            $table->integer('order_id')->change();
            $table->integer('order_product_id')->change();
        });
        Schema::table('giftregistry_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('group_bulletins', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('group_id')->change();
            $table->integer('createdby')->change();
        });
        Schema::table('group_requests', function (Blueprint $table) {
            $table->integer('group_id')->change();
            $table->integer('user_id')->change();
        });
        Schema::table('group_updates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('group_id')->change();
            $table->integer('type_id')->change();
            $table->integer('friend_id')->change();
        });
        Schema::table('group_users', function (Blueprint $table) {
            $table->integer('group_id')->change();
            $table->integer('user_id')->change();
        });
        Schema::table('groups', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('admin_user')->change();
            $table->integer('photo')->change();
        });
        Schema::table('help_pops', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('images', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('images_sizes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('instructors_certfiles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
        });
        Schema::table('inventory_gateways', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('inventory_gateways_accounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_id')->change();
            $table->integer('last_load_id')->change();
            $table->integer('distributor_id')->change();
            $table->integer('base_currency')->change();
        });
        Schema::table('inventory_gateways_fields', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_id')->change();
        });
        Schema::table('inventory_gateways_orders', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_account_id')->change();
            $table->integer('shipment_id')->change();
        });
        Schema::table('inventory_gateways_scheduledtasks', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_account_id')->change();
        });
        Schema::table('inventory_gateways_scheduledtasks_products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('task_id')->change();
            $table->integer('products_id')->change();
            $table->integer('products_distributors_id')->change();
        });
        Schema::table('inventory_gateways_sites', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_account_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('inventory_rules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('languages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('languages_content', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('languages_translations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('content_id')->change();
            $table->integer('language_id')->change();
        });
        Schema::table('loyaltypoints', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('active_level_id')->change();
        });
        Schema::table('loyaltypoints_levels', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('loyaltypoints_id')->change();
        });
        Schema::table('menu', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent')->nullable()->change();
        });
        Schema::table('menu_links', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('menus_catalogcategories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('menu_id')->change();
            $table->integer('category_id')->change();
        });
        Schema::table('menus_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('menu_id')->change();
            $table->integer('category_id')->change();
        });
        Schema::table('menus_links', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('menu_id')->change();
            $table->integer('links_id')->change();
        });
        Schema::table('menus_menus', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('menu_id')->change();
            $table->integer('child_menu_id')->change();
        });
        Schema::table('menus_pages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('menu_id')->change();
            $table->integer('page_id')->change();
            $table->integer('sub_pagemenu_id')->change();
            $table->integer('sub_categorymenu_id')->change();
        });
        Schema::table('menus_sites', function (Blueprint $table) {
            $table->integer('menu_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('message_templates_new', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('mod_resort_details_amenities', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('mods_account_ads', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
        });
        Schema::table('mods_account_ads_campaigns', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('mods_account_ads_clicks', function (Blueprint $table) {
            $table->integer('ad_id')->change();
        });
        Schema::table('mods_account_certifications', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
        });
        Schema::table('mods_account_certifications_files', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('certification_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('mods_account_files', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('mods_dates_auto_orderrules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('mods_dates_auto_orderrules_action', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('dao_id')->change();
            $table->integer('criteria_orderingruleid')->nullable()->change();
            $table->integer('criteria_siteid')->nullable()->change();
            $table->integer('changeto_orderingruleid')->change();
        });
        Schema::table('mods_dates_auto_orderrules_excludes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('dao_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('mods_dates_auto_orderrules_products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('dao_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('mods_lookbooks', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('mods_lookbooks_areas', function (Blueprint $table) {
            $table->integer('area_id')->change();
            $table->integer('lookbook_id')->change();
        });
        Schema::table('mods_lookbooks_areas_images', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('temp_id')->change();
            $table->integer('lookbook_id')->change();
            $table->integer('area_id')->change();
            $table->integer('image_id')->change();
        });
        Schema::table('mods_lookbooks_images', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('mods_lookbooks_images_maps', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('eimage_id')->change();
        });
        // Schema::table('mods_pages_viewed', function (Blueprint $table) {
        //     $table->integer('id')->autoIncrement()->change();
        //     $table->integer('account_id')->change();
        //     $table->integer('page_id')->change();
        // });
        Schema::table('mods_resort_details', function (Blueprint $table) {
            $table->integer('attribute_option_id')->change();
            $table->integer('contact_state_id')->change();
            $table->integer('contact_country_id')->change();
            $table->integer('region_id')->change();
            $table->integer('airport_id')->change();
            $table->integer('fpt_manager_id')->nullable()->change();
        });
        Schema::table('mods_resort_details_amenities', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('resort_details_id')->change();
            $table->integer('amenity_id')->change();
        });
        Schema::table('mods_trip_flyers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('orders_products_id')->change();
            $table->integer('photo_id')->change();
        });
        Schema::table('mods_trip_flyers_settings', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('photo_id')->change();
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('modules_admin_controllers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('module_id')->change();
        });
        Schema::table('modules_crons', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('module_id')->change();
        });
        Schema::table('modules_crons_scheduledtasks', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('modules_fields', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('module_id')->change();
        });
        Schema::table('modules_site_controllers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('module_id')->change();
        });
        Schema::table('modules_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent_template_id')->nullable()->change();
        });
        Schema::table('modules_templates_modules', function (Blueprint $table) {
            $table->integer('template_id')->change();
            $table->integer('module_id')->change();
            $table->integer('section_id')->change();
            $table->integer('temp_id')->change();
        });
        Schema::table('modules_templates_sections', function (Blueprint $table) {
            $table->integer('template_id')->change();
            $table->integer('section_id')->change();
            $table->integer('temp_id')->change();
        });
        Schema::table('newsletters', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('newsletters_history', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('newsletter_id')->change();
        });
        Schema::table('newsletters_sites', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('newsletter_id')->change();
        });
        Schema::table('newsletters_subscribers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('newsletter_id')->change();
        });
        Schema::table('options_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('options_templates_images', function (Blueprint $table) {
            $table->integer('template_id')->change();
            $table->integer('image_id')->change();
        });
        Schema::table('options_templates_options', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('type_id')->change();
            $table->integer('template_id')->change();
        });
        Schema::table('options_templates_options_custom', function (Blueprint $table) {
            $table->integer('value_id')->change();
        });
        Schema::table('options_templates_options_values', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('option_id')->change();
            $table->integer('image_id')->change();
        });
        Schema::table('orders_activities', function (Blueprint $table) {
            $table->integer('order_id')->change();
            $table->integer('user_id')->change();
        });
        Schema::table('orders_billing', function (Blueprint $table) {
            $table->integer('order_id')->change();
            $table->integer('bill_state_id')->change();
            $table->integer('bill_country_id')->change();
        });
        Schema::table('orders_customforms', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('order_id')->change();
            $table->integer('form_id')->change();
            $table->integer('product_id')->change();
            $table->integer('product_type_id')->change();
        });
        Schema::table('orders_discounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('order_id')->change();
            $table->integer('discount_id')->nullable()->change();
            $table->integer('advantage_id')->nullable()->change();
        });
        Schema::table('orders_packages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('shipment_id')->nullable()->change();
        });
        Schema::table('orders_products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('order_id')->change();
            $table->integer('product_id')->change();
            $table->integer('actual_product_id')->change();
            $table->integer('package_id')->change();
            $table->integer('parent_product_id')->nullable()->change();
            $table->integer('cart_id')->change();
            $table->integer('registry_item_id')->change();
        });
        Schema::table('orders_products_customfields', function (Blueprint $table) {
            $table->integer('orders_products_id')->change();
            $table->integer('form_id')->change();
            $table->integer('section_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('orders_products_customsinfo', function (Blueprint $table) {
            $table->integer('orders_products_id')->change();
        });
        Schema::table('orders_products_discounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('orders_products_id')->change();
            $table->integer('discount_id')->change();
            $table->integer('advantage_id')->change();
        });
        Schema::table('orders_products_options', function (Blueprint $table) {
            $table->integer('orders_products_id')->change();
            $table->integer('value_id')->change();
        });
        Schema::table('orders_products_sentemails', function (Blueprint $table) {
            $table->integer('op_id')->change();
            $table->integer('email_id')->change();
        });
        Schema::table('orders_shipments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('order_id')->change();
            $table->integer('distributor_id')->change();
            $table->integer('ship_method_id')->change();
            $table->integer('order_status_id')->change();
        });
        Schema::table('orders_shipments_labels', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('shipment_id')->change();
            $table->integer('package_id')->change();
            $table->integer('label_size_id')->change();
        });
        Schema::table('orders_shipping', function (Blueprint $table) {
            $table->integer('order_id')->change();
            $table->integer('ship_state_id')->change();
            $table->integer('ship_country_id')->change();
        });
        Schema::table('orders_statuses', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('orders_tasks', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('order_id')->change();
        });
        Schema::table('orders_transactions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('order_id')->change();
            $table->integer('account_billing_id')->change();
            $table->integer('payment_method_id')->change();
            $table->integer('gateway_account_id')->change();
            $table->integer('cim_payment_profile_id')->change();
        });
        Schema::table('orders_transactions_billing', function (Blueprint $table) {
            $table->integer('orders_transactions_id')->change();
            $table->integer('bill_state_id')->change();
            $table->integer('bill_country_id')->change();
        });
        Schema::table('orders_transactions_credits', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('orders_transactions_id')->change();
        });
        Schema::table('orders_transactions_statuses', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('pages_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent_category_id')->nullable()->change();
        });
        Schema::table('pages_categories_pages', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->integer('page_id')->change();
        });
        Schema::table('pages_settings', function (Blueprint $table) {
            $table->integer('layout_id')->change();
            $table->integer('settings_template_id')->change();
            $table->integer('module_template_id')->change();
            $table->integer('page_id')->change();
        });
        Schema::table('pages_settings_sites', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('page_id')->change();
            $table->integer('site_id')->change();
            $table->integer('settings_template_id')->nullable()->change();
            $table->integer('layout_id')->nullable()->change();
            $table->integer('module_template_id')->nullable()->change();
        });
        Schema::table('pages_settings_sites_modulevalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('page_id')->change();
            $table->integer('site_id')->change();
            $table->integer('section_id')->change();
            $table->integer('module_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('pages_settings_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('settings_template_id')->nullable()->change();
            $table->integer('layout_id')->nullable()->change();
            $table->integer('module_template_id')->nullable()->change();
        });
        Schema::table('pages_settings_templates_modulevalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('settings_template_id')->change();
            $table->integer('section_id')->change();
            $table->integer('module_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('payment_gateways_accounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_id')->change();
        });
        Schema::table('payment_gateways_accounts_limitcountries', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_account_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('payment_gateways_errors', function (Blueprint $table) {
            $table->integer('gateway_account_id')->change();
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_id')->nullable()->change();
        });
        Schema::table('payment_methods_limitcountries', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('payment_method_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('photos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('addedby')->change();
            $table->integer('album')->change();
        });
        Schema::table('photos_albums', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('type_id')->change();
            $table->integer('recent_photo_id')->change();
        });
        Schema::table('photos_albums_type', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('photos_comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('photo_id')->change();
            $table->integer('account_id')->change();
        });
        Schema::table('photos_favorites', function (Blueprint $table) {
            $table->integer('photo_id')->change();
            $table->integer('account_id')->change();
        });
        Schema::table('photos_sizes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('pricing_rules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('pricing_rules_levels', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('rule_id')->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent_product')->nullable()->change();
            $table->integer('default_outofstockstatus_id')->nullable()->change();
            $table->integer('details_img_id')->nullable()->change();
            $table->integer('category_img_id')->nullable()->change();
            $table->integer('default_distributor_id')->nullable()->change();
            $table->integer('fulfillment_rule_id')->nullable()->change();
        });
        Schema::table('products_accessories', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('accessory_id')->change();
        });
        Schema::table('products_accessories_fields', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('accessories_fields_id')->change();
        });
        Schema::table('products_attributes', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('option_id')->change();
        });
        Schema::table('products_availability', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('products_children_options', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('option_id')->change();
        });
        Schema::table('products_details', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('type_id')->change();
            $table->integer('brand_id')->change();
            $table->integer('default_category_id')->change();
        });
        Schema::table('products_distributors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('product_id')->change();
            $table->integer('distributor_id')->change();
        });
        Schema::table('products_images', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('image_id')->change();
        });
        Schema::table('products_log', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('product_id')->change();
            $table->integer('productdistributor_id')->change();
        });
        Schema::table('products_needschildren', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('option_id')->change();
        });
        Schema::table('products_options', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('product_id')->change();
            $table->integer('type_id')->change();
        });
        Schema::table('products_options_custom', function (Blueprint $table) {
            $table->integer('value_id')->change();
        });
        Schema::table('products_options_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('products_options_values', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('option_id')->change();
            $table->integer('image_id')->change();
        });
        Schema::table('products_pricing', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('site_id')->change();
            $table->integer('pricing_rule_id')->change();
            $table->integer('ordering_rule_id')->change();
        });
        Schema::table('products_pricing_temp', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('site_id')->change();
            $table->integer('pricing_rule_id')->change();
            $table->integer('ordering_rule_id')->change();
        });
        Schema::table('products_related', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('related_id')->change();
        });
        Schema::table('products_resort', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('resort_id')->change();
        });
        Schema::table('products_reviews', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('item_id')->change();
        });
        Schema::table('products_rules_fulfillment', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('products_rules_fulfillment_conditions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('rule_id')->change();
        });
        Schema::table('products_rules_fulfillment_conditions_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('condition_id')->change();
            $table->integer('item_id')->change();
        });
        Schema::table('products_rules_fulfillment_distributors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('rule_id')->change();
            $table->integer('distributor_id')->change();
        });
        Schema::table('products_rules_fulfillment_rules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent_rule_id')->nullable()->change();
            $table->integer('child_rule_id')->change();
        });
        Schema::table('products_rules_ordering', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('products_rules_ordering_conditions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('rule_id')->change();
        });
        Schema::table('products_rules_ordering_conditions_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('condition_id')->change();
            $table->integer('item_id')->change();
        });
        Schema::table('products_rules_ordering_rules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent_rule_id')->nullable()->change();
            $table->integer('child_rule_id')->change();
        });
        Schema::table('products_settings', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('settings_template_id')->change();
            $table->integer('layout_id')->change();
            $table->integer('module_template_id')->change();
        });
        Schema::table('products_settings_sites', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('site_id')->change();
            $table->integer('product_id')->change();
            $table->integer('settings_template_id')->nullable()->change();
            $table->integer('layout_id')->nullable()->change();
            $table->integer('module_template_id')->nullable()->change();
        });
        Schema::table('products_settings_sites_modulevalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('site_id')->change();
            $table->integer('product_id')->change();
            $table->integer('section_id')->change();
            $table->integer('module_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('products_settings_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('settings_template_id')->nullable()->change();
            $table->integer('layout_id')->nullable()->change();
            $table->integer('module_template_id')->nullable()->change();
        });
        Schema::table('products_settings_templates_modulevalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('settings_template_id')->change();
            $table->integer('section_id')->change();
            $table->integer('module_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('products_sorts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('products_specialties', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('specialty_id')->change();
        });
        Schema::table('products_specialties_check', function (Blueprint $table) {
            $table->integer('product_id')->change();
        });
        Schema::table('products_specialtiesaccountsrules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('rule_id')->change();
        });
        Schema::table('products_tasks', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('product_id')->change();
        });
        Schema::table('products_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('products_types_attributes_sets', function (Blueprint $table) {
            $table->integer('type_id')->change();
            $table->integer('set_id')->change();
        });
        Schema::table('products_viewed', function (Blueprint $table) {
            $table->integer('product_id')->change();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('reports_breakdowns', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('reports_products_fields', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('reports_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('resorts_amenities', function (Blueprint $table) {
            $table->integer('resort_id')->change();
            $table->integer('amenity_id')->change();
        });
        Schema::table('saved_cart', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
        });
        Schema::table('saved_cart_discounts', function (Blueprint $table) {
            $table->integer('saved_cart_id')->change();
        });
        Schema::table('saved_cart_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('saved_cart_id')->change();
            $table->integer('product_id')->change();
            $table->integer('cart_id')->change();
            $table->integer('parent_product')->nullable()->change();
            $table->integer('parent_cart_id')->nullable()->change();
            $table->integer('registry_item_id')->change();
            $table->integer('accessory_field_id')->change();
            $table->integer('distributor_id')->change();
        });
        Schema::table('saved_cart_items_customfields', function (Blueprint $table) {
            $table->integer('saved_cart_item_id')->change();
            $table->integer('form_id')->change();
            $table->integer('section_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('saved_cart_items_options', function (Blueprint $table) {
            $table->integer('saved_cart_item_id')->change();
        });
        Schema::table('saved_cart_items_options_customvalues', function (Blueprint $table) {
            $table->integer('saved_cart_item_id')->change();
            $table->integer('option_id')->change();
        });
        Schema::table('saved_order', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('saved_cart_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('saved_order_discounts', function (Blueprint $table) {
            $table->integer('order_id')->change();
            $table->integer('discount_id')->change();
        });
        Schema::table('saved_order_information', function (Blueprint $table) {
            $table->integer('order_id')->change();
            $table->integer('account_billing_id')->change();
            $table->integer('account_shipping_id')->change();
            $table->integer('bill_state_id')->change();
            $table->integer('bill_country_id')->change();
            $table->integer('ship_state_id')->change();
            $table->integer('ship_country_id')->change();
            $table->integer('payment_method_id')->change();
            $table->integer('shipping_method_id')->change();
        });
        Schema::table('search_forms', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('search_forms_fields', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('search_id')->change();
        });
        Schema::table('search_forms_sections', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('form_id')->change();
        });
        Schema::table('search_forms_sections_fields', function (Blueprint $table) {
            $table->integer('section_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('shipping_carriers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_id')->change();
        });
        Schema::table('shipping_carriers_shipto', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('shipping_carriers_id')->change();
            $table->integer('country_id')->change();
        });
        Schema::table('shipping_gateways', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('shipping_label_sizes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('gateway_id')->change();
        });
        Schema::table('shipping_label_templates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('carrier_id')->change();
        });
        Schema::table('shipping_package_sizes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('shipping_package_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('carrier_id')->change();
        });
        Schema::table('shipping_signature_options', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('carrier_id')->change();
        });
        Schema::table('sites_categories', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('category_id')->change();
        });
        Schema::table('sites_currencies', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('currency_id')->change();
        });
        Schema::table('sites_datafeeds', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('datafeed_id')->change();
        });
        Schema::table('sites_inventory_rules', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('rule_id')->change();
        });
        Schema::table('sites_languages', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('language_id')->change();
        });
        Schema::table('sites_message_templates', function (Blueprint $table) {
            $table->integer('site_id')->change();
        });
        Schema::table('sites_packingslip', function (Blueprint $table) {
            $table->integer('site_id')->change();
        });
        Schema::table('sites_payment_methods', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('payment_method_id')->change();
            $table->integer('gateway_account_id')->change();
        });
        Schema::table('sites_settings', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('default_layout_id')->change();
            $table->integer('search_layout_id')->change();
            $table->integer('home_layout_id')->change();
            $table->integer('default_category_layout_id')->change();
            $table->integer('default_product_layout_id')->change();
            $table->integer('account_layout_id')->change();
            $table->integer('cart_layout_id')->change();
            $table->integer('checkout_layout_id')->change();
            $table->integer('page_layout_id')->change();
            $table->integer('affiliate_layout_id')->change();
            $table->integer('wishlist_layout_id')->change();
            $table->integer('default_module_template_id')->change();
            $table->integer('default_category_module_template_id')->change();
            $table->integer('home_module_template_id')->change();
            $table->integer('default_product_module_template_id')->change();
            $table->integer('account_module_template_id')->change();
            $table->integer('search_module_template_id')->change();
            $table->integer('cart_module_template_id')->change();
            $table->integer('checkout_module_template_id')->change();
            $table->integer('page_module_template_id')->change();
            $table->integer('affiliate_module_template_id')->change();
            $table->integer('wishlist_module_template_id')->change();
            $table->integer('catalog_layout_id')->change();
            $table->integer('catalog_module_template_id')->change();
            $table->integer('offline_layout_id')->change();
            $table->integer('default_category_search_form_id')->change();
        });
        Schema::table('sites_settings_modulevalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('site_id')->change();
            $table->integer('section_id')->change();
            $table->integer('module_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('sites_tax_rules', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('tax_rule_id')->change();
        });
        Schema::table('sites_themes', function (Blueprint $table) {
            $table->integer('site_id')->change();
            $table->integer('theme_id')->change();
        });
        Schema::table('states', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('country_id')->change();
        });
        Schema::table('system', function (Blueprint $table) {
            $table->integer('giftcard_template_id')->change();
            $table->integer('giftcard_waccount_template_id')->change();
        });
        Schema::table('system_alerts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('reference_id')->change();
        });
        Schema::table('system_errors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent')->nullable()->change();
            $table->integer('type_id')->change();
            $table->integer('type_subid')->change();
        });
        Schema::table('system_messages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('system_tasks', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('site_id')->change();
        });
        Schema::table('system_updates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('site_id')->change();
        });
        Schema::table('tax_rules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('tax_rules_locations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('tax_rule_id')->change();
            $table->integer('country_id')->change();
            $table->integer('state_id')->change();
        });
        Schema::table('tax_rules_product_types', function (Blueprint $table) {
            $table->integer('tax_rule_id')->change();
            $table->integer('type_id')->change();
        });
        Schema::table('wishlists', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
        });
        Schema::table('wishlists_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('wishlist_id')->change();
            $table->integer('product_id')->change();
            $table->integer('parent_product')->nullable()->change();
            $table->integer('parent_wishlist_items_id')->nullable()->change();
            $table->integer('accessory_field_id')->change();
        });
        Schema::table('wishlists_items_customfields', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('wishlists_item_id')->change();
            $table->integer('form_id')->change();
            $table->integer('section_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('wishlists_items_options', function (Blueprint $table) {
            $table->integer('wishlists_item_id')->change();
        });
        Schema::table('wishlists_items_options_customvalues', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('wishlists_item_id')->change();
            $table->integer('option_id')->change();
        });
    }
};
