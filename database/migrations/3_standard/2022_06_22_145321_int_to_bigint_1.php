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
        Schema::table('accessories_fields', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('accessories_fields_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('accessories_fields_id')->change();
        });
        Schema::table('account_specialties', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->change();
            $table->id()->change();
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('status_id')->change();
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('default_billing_id')->nullable()->change();
            $table->unsignedBigInteger('default_shipping_id')->nullable()->change();
            $table->unsignedBigInteger('affiliate_id')->nullable()->change();
            $table->unsignedBigInteger('cim_profile_id')->nullable()->change();
            $table->unsignedBigInteger('photo_id')->nullable()->change();
            $table->unsignedBigInteger('site_id')->nullable()->change();
            $table->unsignedBigInteger('loyaltypoints_id')->nullable()->change();
        });
        Schema::table('accounts_addressbook', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->id()->change();
            $table->unsignedBigInteger('state_id')->nullable()->change();
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('old_billingid')->change();
            $table->unsignedBigInteger('old_shippingid')->change();
        });
        Schema::table('accounts_addtl_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('form_id')->nullable()->change();
            $table->unsignedBigInteger('section_id')->nullable()->change();
            $table->unsignedBigInteger('field_id')->change();
        });
        Schema::table('accounts_advertising', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
            $table->id()->change();
        });
        Schema::table('accounts_advertising_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('lastshown_ad')->change();
            $table->id()->change();
        });
        Schema::table('accounts_advertising_clicks', function (Blueprint $table) {
            $table->unsignedBigInteger('ad_id')->change();
        });
        Schema::table('accounts_bulletins', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
            $table->id()->change();
        });
        Schema::table('accounts_cims', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->id()->change();
            $table->unsignedBigInteger('cim_profile_id')->nullable()->change();
        });
        Schema::table('accounts_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->id()->change();
            $table->unsignedBigInteger('replyto_id')->nullable()->change();
        });
        Schema::table('accounts_discounts_used', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('discount_id')->nullable()->change();
            $table->unsignedBigInteger('order_id')->change();
        });
        Schema::table('accounts_loyaltypoints', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('loyaltypoints_level_id')->change();
        });
        Schema::table('accounts_loyaltypoints_credits', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('loyaltypoints_level_id')->change();
            $table->id()->change();
            $table->unsignedBigInteger('shipment_id')->change();
        });
        Schema::table('accounts_loyaltypoints_debits', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('loyaltypoints_level_id')->change();
            $table->id()->change();
            $table->unsignedBigInteger('order_id')->change();
        });
        Schema::table('accounts_membership_attributes', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('section_id')->change();
        });
        Schema::table('accounts_membership_attributes_sections', function (Blueprint $table) {
            $table->id()->change();
        });

        // Schema::table('accounts_membership_levels', function (Blueprint $table) {
        //     $table->dropForeign('accounts-membership-levels_auto_renewal_of_foreign');
        // });

        Schema::table('accounts_membership_levels', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('auto_renewal_of')->nullable()->change();
            $table->unsignedBigInteger('annual_product_id')->change();
            $table->unsignedBigInteger('monthly_product_id')->nullable()->change();
            $table->unsignedBigInteger('affiliate_level_id')->change();

            $table->foreign('auto_renewal_of')->references('id')->on('accounts_membership_levels');
        });
        Schema::table('accounts_membership_levels_attributes', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('level_id')->change();
            $table->unsignedBigInteger('attribute_id')->change();
        });
        Schema::table('accounts_membership_levels_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->change();
        });
        Schema::table('accounts_memberships', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('order_id')->nullable()->change();
            $table->id()->change();
            $table->unsignedBigInteger('membership_id')->nullable()->change();
        });
        Schema::table('accounts_memberships_payment_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_method_id')->change();
            $table->unsignedBigInteger('gateway_account_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('accounts_messages', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('header_id')->nullable()->change();
            $table->unsignedBigInteger('replied_id')->nullable()->change();
            $table->unsignedBigInteger('to_id')->nullable()->change();
            $table->unsignedBigInteger('from_id')->nullable()->change();
        });
        Schema::table('accounts_messages_headers', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('accounts_onmind', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
        });
        Schema::table('accounts_onmind_comments', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('onmind_id')->nullable()->change();
        });
        Schema::table('accounts_onmind_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('onmind_id')->nullable()->change();
        });
        Schema::table('accounts_programs', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('accounts_programs_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('program_id')->change();
        });
        Schema::table('accounts_resourcebox', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('accounts_specialties', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('specialty_id')->nullable()->change();
        });
        Schema::table('accounts_specialties_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('specialty_id')->change();
        });
        Schema::table('accounts_statuses', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('accounts_templates_sent', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('template_id')->nullable()->change();
        });
        Schema::table('accounts_transactions', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('membership_id')->change();
            $table->unsignedBigInteger('payment_profile_id')->change();
        });
        Schema::table('accounts_types', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('custom_form_id')->nullable()->change();
            $table->unsignedBigInteger('discount_level_id')->nullable()->change();
            $table->unsignedBigInteger('loyaltypoints_id')->nullable()->change();
            $table->unsignedBigInteger('membership_level_id')->nullable()->change();
            $table->unsignedBigInteger('affiliate_level_id')->nullable()->change();
        });
        Schema::table('accounts_types_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('category_id')->change();
        });
        Schema::table('accounts_types_products', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accessories_fields', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accessories_fields_products', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('accessories_fields_id')->change();
        });
        Schema::table('account_specialties', function (Blueprint $table) {
            $table->integer('parent_id')->nullable()->change();
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('status_id')->change();
            $table->integer('type_id')->change();
            $table->integer('default_billing_id')->nullable()->change();
            $table->integer('default_shipping_id')->nullable()->change();
            $table->integer('affiliate_id')->change();
            $table->integer('cim_profile_id')->change();
            $table->integer('photo_id')->change();
            $table->integer('site_id')->change();
            $table->integer('loyaltypoints_id')->change();
        });
        Schema::table('accounts_addressbook', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('id')->autoIncrement()->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
            $table->integer('old_billingid')->change();
            $table->integer('old_shippingid')->change();
        });
        Schema::table('accounts_addtl_fields', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('form_id')->change();
            $table->integer('section_id')->change();
            $table->integer('field_id')->change();
        });
        Schema::table('accounts_advertising', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts_advertising_campaigns', function (Blueprint $table) {
            $table->integer('lastshown_ad')->change();
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts_advertising_clicks', function (Blueprint $table) {
            $table->integer('ad_id')->change();
        });
        Schema::table('accounts_bulletins', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts_cims', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('id')->autoIncrement()->change();
            $table->integer('cim_profile_id')->change();
        });
        Schema::table('accounts_comments', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('id')->autoIncrement()->change();
            $table->integer('replyto_id')->change();
        });
        Schema::table('accounts_discounts_used', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('discount_id')->change();
            $table->integer('order_id')->change();
        });
        Schema::table('accounts_loyaltypoints', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('loyaltypoints_level_id')->change();
        });
        Schema::table('accounts_loyaltypoints_credits', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('loyaltypoints_level_id')->change();
            $table->integer('id')->autoIncrement()->change();
            $table->integer('shipment_id')->change();
        });
        Schema::table('accounts_loyaltypoints_debits', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('loyaltypoints_level_id')->change();
            $table->integer('id')->autoIncrement()->change();
            $table->integer('order_id')->change();
        });
        Schema::table('accounts_membership_attributes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('section_id')->change();
        });
        Schema::table('accounts_membership_attributes_sections', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts_membership_levels', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('annual_product_id')->change();
            $table->integer('monthly_product_id')->change();
            $table->integer('affiliate_level_id')->change();
        });
        Schema::table('accounts_membership_levels_attributes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('level_id')->change();
            $table->integer('attribute_id')->change();
        });
        Schema::table('accounts_membership_levels_settings', function (Blueprint $table) {
            $table->integer('level_id')->change();
        });
        Schema::table('accounts_memberships', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('product_id')->change();
            $table->integer('order_id')->change();
            $table->integer('id')->autoIncrement()->change();
            $table->integer('membership_id')->change();
        });
        Schema::table('accounts_memberships_payment_methods', function (Blueprint $table) {
            $table->integer('payment_method_id')->change();
            $table->integer('gateway_account_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('accounts_messages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('header_id')->change();
            $table->integer('replied_id')->change();
            $table->integer('to_id')->change();
            $table->integer('from_id')->change();
        });
        Schema::table('accounts_messages_headers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts_onmind', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
        });
        Schema::table('accounts_onmind_comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('onmind_id')->change();
            $table->integer('comment_id')->change();
        });
        Schema::table('accounts_onmind_likes', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('onmind_id')->change();
        });
        Schema::table('accounts_programs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts_programs_accounts', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('program_id')->change();
        });
        Schema::table('accounts_resourcebox', function (Blueprint $table) {
            $table->integer('account_id')->change();
        });
        Schema::table('accounts_specialties', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('specialty_id')->change();
        });
        Schema::table('accounts_specialties_products', function (Blueprint $table) {
            $table->integer('product_id')->change();
            $table->integer('specialty_id')->change();
        });
        Schema::table('accounts_statuses', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('accounts_templates_sent', function (Blueprint $table) {
            $table->integer('account_id')->change();
            $table->integer('template_id')->change();
        });
        Schema::table('accounts_transactions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('membership_id')->change();
            $table->integer('payment_profile_id')->change();
        });
        Schema::table('accounts_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('custom_form_id')->change();
            $table->integer('discount_level_id')->change();
            $table->integer('loyaltypoints_id')->change();
            $table->integer('membership_level_id')->change();
            $table->integer('affiliate_level_id')->change();
        });
        Schema::table('accounts_types_categories', function (Blueprint $table) {
            $table->integer('type_id')->change();
            $table->integer('category_id')->change();
        });
        Schema::table('accounts_types_products', function (Blueprint $table) {
            $table->integer('type_id')->change();
            $table->integer('product_id')->change();
        });
    }
};
