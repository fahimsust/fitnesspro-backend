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
        Schema::table('accounts_types_restrictordering', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->change();
            $table->unsignedBigInteger('product_id')->change();
        });
        Schema::table('accounts_updates', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('accounts_views', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->change();
        });
        Schema::table('admin_emails_sent', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->unsignedBigInteger('template_id')->nullable()->change();
            $table->unsignedBigInteger('sent_by')->change();
            $table->unsignedBigInteger('order_id')->nullable()->change();
        });
        Schema::table('admin_levels', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('admin_levels_menus', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->change();
            $table->unsignedBigInteger('menu_id')->change();
        });
        Schema::table('admin_users', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('level_id')->nullable()->change();
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('admin_users_distributors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('distributor_id')->change();
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('state_id')->nullable()->change();
            $table->unsignedBigInteger('country_id')->change();
            $table->unsignedBigInteger('affiliate_level_id')->nullable()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
        });
        Schema::table('affiliates_levels', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('affiliates_payments', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('affiliate_id')->change();
        });
        Schema::table('affiliates_payments_referrals', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id')->change();
            $table->unsignedBigInteger('referral_id')->change();
        });
        Schema::table('affiliates_referrals', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('affiliate_id')->change();
            $table->unsignedBigInteger('order_id')->nullable()->change();
            $table->unsignedBigInteger('status_id')->change();
            $table->unsignedBigInteger('type_id')->change();
        });
        Schema::table('affiliates_referrals_statuses', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('affiliates_referrals_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('airports', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->change();
            $table->unsignedBigInteger('photo')->change();
        });
        Schema::table('articles_categories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_id')->nullable()->change();
        });
        Schema::table('articles_comments', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('article_id')->change();
            $table->unsignedBigInteger('createdby')->change();
        });
        Schema::table('articles_resources', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->change();
        });
        Schema::table('articles_views', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->change();
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('attributes', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('type_id')->change();
        });
        Schema::table('attributes_options', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('attribute_id')->change();
        });
        Schema::table('attributes_packages', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('attributes_packages_sets', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->change();
            $table->unsignedBigInteger('set_id')->change();
        });
        Schema::table('attributes_sets', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('attributes_sets_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_id')->change();
            $table->unsignedBigInteger('set_id')->change();
        });
        Schema::table('attributes_types', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('automated_emails', function (Blueprint $table) {
            $table->unsignedBigInteger('message_template_id')->change();
            $table->id()->change();
        });
        Schema::table('automated_emails_accounttypes', function (Blueprint $table) {
            $table->unsignedBigInteger('automated_email_id')->change();
            $table->unsignedBigInteger('account_type_id')->change();
        });
        Schema::table('automated_emails_sites', function (Blueprint $table) {
            $table->unsignedBigInteger('automated_email_id')->change();
            $table->unsignedBigInteger('site_id')->change();
        });
        Schema::table('banners_campaigns', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('banners_clicks', function (Blueprint $table) {
            $table->unsignedBigInteger('banner_id')->change();
        });
        Schema::table('banners_images', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('campaign_id')->change();
        });
        Schema::table('banners_shown', function (Blueprint $table) {
            $table->unsignedBigInteger('banner_id')->change();
        });
        Schema::table('blog_entry', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('blog_id')->change();
            $table->unsignedBigInteger('photo')->change();
            $table->unsignedBigInteger('createdby')->change();
        });
        Schema::table('blog_entry_comments', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('entry_id')->change();
            $table->unsignedBigInteger('createdby')->change();
        });
        Schema::table('blog_entry_views', function (Blueprint $table) {
            $table->unsignedBigInteger('entry_id')->change();
            $table->unsignedBigInteger('account_id')->change();
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('createdby')->change();
            $table->unsignedBigInteger('photo')->change();
        });
        Schema::table('blogs_views', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_id')->change();
            $table->unsignedBigInteger('account_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts_types_restrictordering', function (Blueprint $table) {
            $table->integer('type_id')->change();
            $table->integer('product_id')->change();
        });
        Schema::table('accounts_updates', function (Blueprint $table) {
            $table->integer('account_id')->change();
        });
        Schema::table('accounts_views', function (Blueprint $table) {
            $table->integer('profile_id')->change();
            $table->integer('account_id')->change();
        });
        Schema::table('admin_emails_sent', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('template_id')->change();
            $table->integer('sent_by')->change();
            $table->integer('order_id')->change();
        });
        Schema::table('admin_levels', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('admin_levels_menus', function (Blueprint $table) {
            $table->integer('level_id')->change();
            $table->integer('menu_id')->change();
        });
        Schema::table('admin_users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('level_id')->change();
            $table->integer('account_id')->nullable()->change();
        });
        Schema::table('admin_users_distributors', function (Blueprint $table) {
            $table->integer('user_id')->change();
            $table->integer('distributor_id')->change();
        });
        Schema::table('affiliates', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('state_id')->change();
            $table->integer('country_id')->change();
            $table->integer('affiliate_level_id')->change();
            $table->integer('account_id')->change();
        });
        Schema::table('affiliates_levels', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('affiliates_payments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('affiliate_id')->change();
        });
        Schema::table('affiliates_payments_referrals', function (Blueprint $table) {
            $table->integer('payment_id')->change();
            $table->integer('referral_id')->change();
        });
        Schema::table('affiliates_referrals', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('affiliate_id')->change();
            $table->integer('order_id')->change();
            $table->integer('status_id')->change();
            $table->integer('type_id')->change();
        });
        Schema::table('affiliates_referrals_statuses', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('affiliates_referrals_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('airports', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('account_id')->change();
            $table->integer('photo')->change();
        });
        Schema::table('articles_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('parent_id')->nullable()->change();
        });
        Schema::table('articles_comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('article_id')->change();
            $table->integer('createdby')->change();
        });
        Schema::table('articles_resources', function (Blueprint $table) {
            $table->integer('article_id')->change();
        });
        Schema::table('articles_views', function (Blueprint $table) {
            $table->integer('article_id')->change();
            $table->integer('account_id')->change();
        });
        Schema::table('attributes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('type_id')->change();
        });
        Schema::table('attributes_options', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('attribute_id')->change();
        });
        Schema::table('attributes_packages', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('attributes_packages_sets', function (Blueprint $table) {
            $table->integer('package_id')->change();
            $table->integer('set_id')->change();
        });
        Schema::table('attributes_sets', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('attributes_sets_attributes', function (Blueprint $table) {
            $table->integer('attribute_id')->change();
            $table->integer('set_id')->change();
        });
        Schema::table('attributes_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('automated_emails', function (Blueprint $table) {
            $table->integer('message_template_id')->change();
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('automated_emails_accounttypes', function (Blueprint $table) {
            $table->integer('automated_email_id')->change();
            $table->integer('account_type_id')->change();
        });
        Schema::table('automated_emails_sites', function (Blueprint $table) {
            $table->integer('automated_email_id')->change();
            $table->integer('site_id')->change();
        });
        Schema::table('banners_campaigns', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });
        Schema::table('banners_clicks', function (Blueprint $table) {
            $table->integer('banner_id')->change();
        });
        Schema::table('banners_images', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('campaign_id')->change();
        });
        Schema::table('banners_shown', function (Blueprint $table) {
            $table->integer('banner_id')->change();
        });
        Schema::table('blog_entry', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('blog_id')->change();
            $table->integer('photo')->change();
            $table->integer('createdby')->change();
        });
        Schema::table('blog_entry_comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('entry_id')->change();
            $table->integer('createdby')->change();
        });
        Schema::table('blog_entry_views', function (Blueprint $table) {
            $table->integer('entry_id')->change();
            $table->integer('account_id')->change();
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
            $table->integer('createdby')->change();
            $table->integer('photo')->change();
        });
        Schema::table('blogs_views', function (Blueprint $table) {
            $table->integer('blog_id')->change();
            $table->integer('account_id')->change();
        });
    }
};
