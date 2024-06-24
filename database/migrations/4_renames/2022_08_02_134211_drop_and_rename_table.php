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
        //
        Schema::dropIfExists('banners_shown');
        Schema::dropIfExists('banners_clicks');
        Schema::dropIfExists('banners_images');
        Schema::dropIfExists('banners_campaigns');

        Schema::dropIfExists('articles_views');
        Schema::dropIfExists('articles_comments');
        Schema::dropIfExists('articles_resources');
        Schema::dropIfExists('articles_categories');
        Schema::dropIfExists('articles');

        Schema::dropIfExists('instructors_certfiles');
        Schema::dropIfExists('accounts_bulletins');
        Schema::dropIfExists('accounts_types_products');
        Schema::dropIfExists('accounts_types_categories');
        Schema::dropIfExists('accounts_types_restrictordering');
        Schema::dropIfExists('accounts_updates');
        Schema::dropIfExists('accounts_transactions');
        Schema::dropIfExists('accounts_specialties_products');
        Schema::dropIfExists('accounts_resourcebox');
        Schema::dropIfExists('accounts_programs_accounts');
        Schema::dropIfExists('accounts_programs');
        Schema::dropIfExists('accounts_advertising_clicks');
        Schema::dropIfExists('accounts_advertising_campaigns');
        Schema::dropIfExists('accounts_advertising');

        Schema::dropIfExists('blog_entry_comments');
        Schema::dropIfExists('blog_entry_views');
        Schema::dropIfExists('blog_entry');
        Schema::dropIfExists('blogs_views');
        Schema::dropIfExists('blogs');

       // Schema::dropIfExists('mods_pages_viewed');

        Schema::dropIfExists('board_type');
        Schema::dropIfExists('board_threads');
        Schema::dropIfExists('board_categories');
        Schema::dropIfExists('board_thread_entry');
        Schema::dropIfExists('board_threads_details');
        Schema::dropIfExists('boards');

        Schema::dropIfExists('newsletters_sites');
        Schema::dropIfExists('newsletters_history');
        Schema::dropIfExists('newsletters_subscribers');
        Schema::dropIfExists('newsletters');

        Schema::dropIfExists('group_users');
        Schema::dropIfExists('group_views');
        Schema::dropIfExists('group_updates');
        Schema::dropIfExists('group_requests');
        Schema::dropIfExists('group_bulletins');
        Schema::dropIfExists('groups');

        Schema::dropIfExists('mods_lookbooks_images_maps');
        Schema::dropIfExists('mods_lookbooks_areas_images');
        Schema::dropIfExists('mods_lookbooks_images');
        Schema::dropIfExists('mods_lookbooks_areas');
        Schema::dropIfExists('mods_lookbooks');

        Schema::dropIfExists('attributes_packages_sets');
        Schema::dropIfExists('attributes_packages');

        Schema::dropIfExists('discounts_rules_products');
        Schema::dropIfExists('discounts_advantages_products');
        Schema::dropIfExists('discounts_rules');
        Schema::dropIfExists('discounts_advantages');
        Schema::dropIfExists('discounts_old');

        Schema::dropIfExists('message_templates_new');
        Schema::dropIfExists('resorts_amenities');
        Schema::dropIfExists('resorts');

        Schema::dropIfExists('system_updates');
        Schema::dropIfExists('system_tasks');
        Schema::dropIfExists('system_messages');
        Schema::dropIfExists('system_logs');
        Schema::dropIfExists('system_alerts');
        Schema::dropIfExists('system_errors');
        Schema::dropIfExists('resorts_old');

        Schema::dropIfExists('sites_datafeeds');

        Schema::rename('account_specialties', 'specialties');
        Schema::rename('mods_account_files', 'account_files');
        Schema::rename('mods_account_ads', 'account_ads');
        Schema::rename('mods_account_ads_clicks', 'account_ads_clicks');
        Schema::rename('mods_account_ads_campaigns', 'account_ads_campaigns');

        Schema::rename('mods_account_certifications', 'account_certifications');
        Schema::rename('mods_account_certifications_files', 'account_certifications_files');

        Schema::rename('mods_trip_flyers', 'trip_flyers');
        Schema::rename('mods_trip_flyers_settings', 'trip_flyers_settings');

        Schema::rename('mods_dates_auto_orderrules', 'dates_auto_orderrules');
        Schema::rename('mods_dates_auto_orderrules_action', 'dates_auto_orderrules_action');
        Schema::rename('mods_dates_auto_orderrules_excludes', 'dates_auto_orderrules_excludes');
        Schema::rename('mods_dates_auto_orderrules_products', 'dates_auto_orderrules_products');

        Schema::rename('mods_resort_details', 'resorts');
        Schema::rename('mods_resort_details_amenities', 'resorts_amenities');

        Schema::rename('accounts_memberships', 'membership_subscriptions');
        Schema::rename('accounts_membership_levels', 'membership_levels');
        Schema::rename('accounts_membership_attributes', 'membership_attributes');
        Schema::rename('accounts_memberships_payment_methods', 'membership_payment_methods');
        Schema::rename('accounts_membership_levels_settings', 'membership_levels_settings');
        Schema::rename('accounts_membership_levels_attributes', 'membership_levels_attributes');
        Schema::rename('accounts_membership_attributes_sections', 'membership_attributes_sections');

        Schema::rename('saved_cart', 'cart');
        Schema::rename('saved_cart_items', 'cart_items');
        Schema::rename('saved_cart_discounts', 'cart_discounts');
        Schema::rename('saved_cart_items_options', 'cart_items_options');
        Schema::rename('saved_cart_items_customfields', 'cart_items_customfields');
        Schema::rename('saved_cart_items_options_customvalues', 'cart_items_options_customvalues');

        Schema::table('cart_discounts', function (Blueprint $table) {
            $table->renameColumn('saved_cart_id', 'cart_id');
        });
        //@john there is another field name cart_id what should I do
        // Schema::table('cart_items', function (Blueprint $table) {
        //     $table->renameColumn('saved_cart_id', 'cart_id');
        // });
        Schema::table('saved_order', function (Blueprint $table) {
            $table->renameColumn('saved_cart_id', 'cart_id');
        });
        Schema::table('cart_items_customfields', function (Blueprint $table) {
            $table->renameColumn('saved_cart_item_id', 'cart_item_id');
        });
        Schema::table('cart_items_options', function (Blueprint $table) {
            $table->renameColumn('saved_cart_item_id', 'cart_item_id');
        });
        Schema::table('cart_items_options_customvalues', function (Blueprint $table) {
            $table->renameColumn('saved_cart_item_id', 'cart_item_id');
        });



        Schema::table('orders_products_sentemails', function (Blueprint $table) {
            $table->renameColumn('op_id', 'orders_products_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //banners
        Schema::create('banners_campaigns', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('location', 100);
            $table->integer('width');
            $table->integer('height');
            $table->boolean('new_window');
            $table->boolean('status');
        });
        Schema::create('banners_clicks', function (Blueprint $table) {
            $table->integer('banner_id')->index('banner_id');
            $table->dateTime('clicked');
        });
        Schema::create('banners_images', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('campaign_id')->index('campaign_id');
            $table->string('name', 55);
            $table->string('link');
            $table->string('image', 100);
            $table->integer('clicks_no');
            $table->integer('show_no');
            $table->boolean('status');
        });
        Schema::create('banners_shown', function (Blueprint $table) {
            $table->integer('banner_id')->index('bash_banner_id');
            $table->dateTime('shown');
        });

        //articles
        Schema::create('articles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('headline');
            $table->string('short_headline', 35);
            $table->string('author', 155);
            $table->longText('body');
            $table->integer('photo');
            $table->integer('account_id');
            $table->dateTime('created');
            $table->dateTime('updated');
            $table->integer('category');
            $table->integer('views')->index('rank');
            $table->boolean('featured');
            $table->string('url_name', 55);
        });
        Schema::create('articles_resources', function (Blueprint $table) {
            $table->integer('article_id')->primary();
            $table->string('keywords', 500);
            $table->string('about_author', 500);
            $table->string('link_1');
            $table->string('link_2');
            $table->string('link_1_title', 65);
            $table->string('link_2_title', 65);
        });
        Schema::create('articles_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('article_id')->index('entry_id');
            $table->text('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->boolean('beenread')->default(0);
            $table->string('name', 55);
            $table->string('webaddress');
        });
        Schema::create('articles_categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->index('artcat_parent_id');
            $table->string('name', 100);
            $table->string('url_name', 55);
        });
        Schema::create('articles_views', function (Blueprint $table) {
            $table->integer('article_id');
            $table->integer('account_id');
            $table->date('viewed_date');
            $table->time('viewed_time');
            $table->index(['article_id', 'account_id'], 'article_id');
        });

        //instructors_certfiles
        Schema::create('instructors_certfiles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('filename');
            $table->integer('account_id')->index('ince_account_id');
            $table->dateTime('upload_date');
        });

        //accounts
        Schema::create('accounts_bulletins', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('ab_account_id');
            $table->string('subject', 155);
            $table->text('body');
            $table->dateTime('created');
        });
        Schema::create('accounts_types_categories', function (Blueprint $table) {
            $table->integer('type_id')->index('atypec_type_id_2');
            $table->integer('category_id')->index('atypec_product_id');
            $table->unique(['type_id', 'category_id'], 'atypec_type_id');
        });
        Schema::create('accounts_types_products', function (Blueprint $table) {
            $table->integer('type_id')->index('atypep_type_id_2');
            $table->integer('product_id')->index('atypep_product_id');
            $table->unique(['type_id', 'product_id'], 'atypep_type_id');
        });
        Schema::create('accounts_types_restrictordering', function (Blueprint $table) {
            $table->integer('type_id')->index('atyper_type_id_2');
            $table->integer('product_id')->index('atyper_product_id');
            $table->unique(['type_id', 'product_id'], 'atyper_type_id');
        });
        Schema::create('accounts_updates', function (Blueprint $table) {
            $table->integer('account_id')->primary();
            $table->boolean('newmessages')->default(0);
        });
        Schema::create('accounts_transactions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('transid', 35);
            $table->string('ccnum', 4);
            $table->tinyInteger('ccexpmonth');
            $table->year('ccexpyear');
            $table->integer('account_id')->index('atrans_account_id');
            $table->string('zipcode', 15);
            $table->decimal('amount');
            $table->tinyInteger('status');
            $table->string('description');
            $table->decimal('orig_amount');
            $table->decimal('disc_amount');
            $table->string('disc_code', 55);
            $table->dateTime('created');
            $table->integer('membership_id');
            $table->integer('payment_profile_id');
        });
        Schema::create('accounts_specialties_products', function (Blueprint $table) {
            $table->integer('specialty_id')->index('aspecp_type_id_2');
            $table->integer('product_id')->index('aspecp_product_id');
            $table->unique(['specialty_id', 'product_id'], 'aspecp_type_id');
        });
        Schema::create('accounts_resourcebox', function (Blueprint $table) {
            $table->integer('account_id')->primary();
            $table->string('keywords');
            $table->string('about_author', 500);
            $table->string('link_1');
            $table->string('link_2');
            $table->string('link_1_title', 65);
            $table->string('link_2_title', 65);
        });
        Schema::create('accounts_programs_accounts', function (Blueprint $table) {
            $table->integer('account_id')->index('apro_account_id');
            $table->integer('program_id');
        });
        Schema::create('accounts_programs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
        });
        Schema::create('accounts_advertising', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('aa_account_id');
            $table->string('name');
            $table->string('link', 500);
            $table->string('img', 155);
            $table->integer('clicks');
            $table->integer('shown');
            $table->boolean('status')->default(1);
        });
        Schema::create('accounts_advertising_clicks', function (Blueprint $table) {
            $table->integer('ad_id')->index('ad_id');
            $table->dateTime('clicked');
        });
        Schema::create('accounts_advertising_campaigns', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lastshown_ad');
        });

        //blog
        Schema::create('blog_entry_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('entry_id')->index('blec_entry_id');
            $table->text('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->boolean('beenread')->default(0);
            $table->string('name', 55);
            $table->string('webaddress');
        });
        Schema::create('blog_entry', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('blog_id');
            $table->binary('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('updated');
            $table->boolean('allowcomments');
            $table->string('title', 100);
            $table->string('short_title', 35);
            $table->string('subtitle');
            $table->integer('views');
            $table->integer('photo');
            $table->string('url_name');
        });
        Schema::create('blog_entry_views', function (Blueprint $table) {
            $table->integer('entry_id');
            $table->integer('account_id');
            $table->date('viewed_date');
            $table->time('viewed_time');
            $table->index(['entry_id', 'account_id'], 'blev_entry_id');
        });
        Schema::create('blogs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 155);
            $table->string('description', 800);
            $table->integer('createdby');
            $table->dateTime('created');
            $table->dateTime('updated');
            $table->dateTime('lastposted');
            $table->boolean('allowcomments');
            $table->integer('views');
            $table->integer('photo');
            $table->boolean('featured');
            $table->string('url_name');
        });
        Schema::create('blogs_views', function (Blueprint $table) {
            $table->integer('blog_id')->index('blvi_blog_id');
            $table->string('account_id', 10)->index('blvi_account_id');
            $table->date('viewed_date');
            $table->time('viewed_time');
        });

        //Boards
        Schema::create('board_categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 155);
            $table->string('description');
            $table->integer('board_id');
            $table->dateTime('created');
            $table->tinyInteger('rank');
        });
        Schema::create('board_thread_entry', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('thread_id')->index('thread_id');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->text('body');
            $table->dateTime('updated');
        });
        Schema::create('board_threads_details', function (Blueprint $table) {
            $table->integer('thread_id')->primary();
            $table->string('keywords', 500);
            $table->string('city', 35);
            $table->string('state', 2);
            $table->string('country', 2);
            $table->string('zipcode', 15);
            $table->string('webaddress', 100);
            $table->string('email', 85);
            $table->string('phone', 15);
        });
        Schema::create('board_threads', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id');
            $table->string('name');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('updated');
            $table->integer('updatedby');
            $table->boolean('allowreply')->default(1);
            $table->dateTime('lastpost');
            $table->integer('lastposter');
            $table->integer('photo');
            $table->boolean('status');
        });

        Schema::create('board_type', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
        });

        Schema::create('boards', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
            $table->dateTime('created');
            $table->tinyInteger('type');
            $table->integer('group_id');
            $table->boolean('status')->default(1);
        });

        //mods_pages_viewed
        Schema::create('mods_pages_viewed', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id');
            $table->integer('page_id');
        });

        //newsletters
        Schema::create('newsletters_history', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('newsletter_id')->index('newsletter_id');
            $table->string('subject', 155);
            $table->text('body');
            $table->dateTime('sent');
            $table->integer('subscribers_no');
        });
        Schema::create('newsletters_sites', function (Blueprint $table) {
            $table->integer('newsletter_id')->index('nesi_newsletter_id');
            $table->integer('site_id');
        });
        Schema::create('newsletters_subscribers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('newsletter_id')->index('nesu_newsletter_id');
            $table->string('name', 85);
            $table->string('email', 85);
            $table->dateTime('joined');
        });
        Schema::create('newsletters', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->text('description');
            $table->string('url_name', 65);
            $table->string('from_name', 55);
            $table->string('from_email', 85);
            $table->boolean('show_in_checkout');
        });

        //group
        Schema::create('group_bulletins', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('group_id');
            $table->string('subject', 155);
            $table->text('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->index(['group_id', 'createdby'], 'group_id');
        });
        Schema::create('group_requests', function (Blueprint $table) {
            $table->integer('group_id');
            $table->integer('user_id');
            $table->string('note');
            $table->dateTime('created');
            $table->boolean('status')->default(0);
            $table->index(['group_id', 'user_id'], 'grre_group_id');
        });
        Schema::create('group_updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('group_id');
            $table->tinyInteger('type');
            $table->integer('type_id');
            $table->dateTime('updated');
            $table->integer('friend_id');
            $table->integer('num');
        });
        Schema::create('group_users', function (Blueprint $table) {
            $table->integer('group_id');
            $table->integer('user_id');
            $table->dateTime('joined');
            $table->boolean('admin');
            $table->index(['group_id', 'user_id'], 'grus_group_id');
        });
        Schema::create('group_views', function (Blueprint $table) {
            $table->integer('group_id');
            $table->integer('account_id');
            $table->date('viewed_date');
            $table->time('viewed_time');
            $table->index(['group_id', 'account_id'], 'grvi_group_id');
        });
        Schema::create('groups', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->dateTime('created');
            $table->integer('admin_user');
            $table->string('description');
            $table->integer('photo');
            $table->integer('views');
            $table->boolean('featured');
        });

        //mods_lookbooks

        Schema::create('mods_lookbooks_areas_images', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('temp_id');
            $table->integer('lookbook_id')->index('lookbook_id');
            $table->integer('area_id');
            $table->integer('image_id');
            $table->string('link', 155);
            $table->decimal('timing', 4, 1)->default(1.0);
            $table->boolean('static');
            $table->tinyInteger('rank');
            $table->integer('width');
            $table->integer('height');
            $table->text('content_title');
            $table->text('content_desc');
            $table->string('content_width', 10);
            $table->string('content_top', 10);
            $table->string('content_bottom', 10);
            $table->string('content_left', 10);
            $table->string('content_right', 10);
        });
        Schema::create('mods_lookbooks_areas', function (Blueprint $table) {
            $table->integer('lookbook_id')->index('moloar_lookbook_id');
            $table->integer('area_id');
            $table->text('text');
            $table->tinyInteger('use_static');
            $table->decimal('timing', 4, 1)->default(1.0);
            $table->boolean('show_thumbs')->default(0);
            $table->boolean('show_arrows')->default(0);
        });
        Schema::create('mods_lookbooks_images_maps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eimage_id');
            $table->boolean('shape');
            $table->text('coord');
            $table->string('href');
            $table->tinyInteger('target');
            $table->string('title');
            $table->text('description');
            $table->boolean('popup_position');
            $table->integer('popup_offsetx');
            $table->integer('popup_offsety');
            $table->integer('popup_width')->default(200);
        });
        Schema::create('mods_lookbooks_images', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('filename', 100);
            $table->boolean('status');
            $table->string('link');
        });
        Schema::create('mods_lookbooks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 155);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('config_id', 55);
            $table->boolean('status');
            $table->boolean('default_status');
            $table->text('header_text');
            $table->text('footer_text');
            $table->string('meta_title');
            $table->string('meta_desc');
            $table->string('meta_keywords');
            $table->integer('galleries_thumbnail');
            $table->enum('plugin_type', ['tn3', 'cycle2'])->default('tn3');
        });

        //attributes-packages

        Schema::create('attributes_packages_sets', function (Blueprint $table) {
            $table->integer('package_id');
            $table->integer('set_id');
            $table->index(['package_id', 'set_id'], 'package_id');
        });
        Schema::create('attributes_packages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
        });

        //Discounts
        Schema::create('discounts_old', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('display', 85);
            $table->dateTime('start_date');
            $table->dateTime('exp_date');
            $table->boolean('status');
        });
        Schema::create('discounts_rules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('discount_id')->index('dirules_discount_id');
            $table->integer('rule_type_id');
            $table->decimal('required_cart_value', 10);
            $table->integer('required_product_qty');
            $table->string('required_code', 25);
        });
        Schema::create('discounts_rules_products', function (Blueprint $table) {
            $table->integer('rule_id')->index('diruprod_rule_id');
            $table->integer('product_id');
            $table->unique(['rule_id', 'product_id'], 'diruprod_rule_id_2');
        });
        Schema::create('discounts_advantages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('discount_id')->index('diad_discount_id');
            $table->integer('advantage_type_id');
            $table->decimal('flat_amount', 10);
            $table->decimal('percentage_amount', 6);
            $table->integer('product_qty');
            $table->integer('apply_shipping_id');
        });
        Schema::create('discounts_advantages_products', function (Blueprint $table) {
            $table->integer('advantage_id')->index('diadp_advantage_id');
            $table->integer('product_id');
        });

        //message_templates_new
        Schema::create('message_templates_new', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('subject');
            $table->text('alt_body');
            $table->text('html_body');
            $table->string('note');
        });

        //resorts
        Schema::create('resorts_amenities', function (Blueprint $table) {
            $table->integer('resort_id')->index('resort_id');
            $table->integer('amenity_id');
            $table->tinyInteger('details')->comment('1=included, 2=addtl cost, 3=available, 4=not available, 5=other');
        });
        //systems
        Schema::create('system_alerts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->tinyInteger('reference_type')->comment('0 = other, 1 = order, 2 = transaction, 3 = shipment, 4 = package, 5 = account, 6 = product');
            $table->integer('reference_id')->index('reference_id');
            $table->text('description');
            $table->dateTime('created');
            $table->boolean('been_read');
            $table->dateTime('read_on');
            $table->index(['reference_type', 'reference_id'], 'reference_type');
        });
        Schema::create('system_errors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent')->index('parent');
            $table->dateTime('created');
            $table->text('error');
            $table->text('details');
            $table->text('moredetails');
            $table->integer('type_id');
            $table->tinyInteger('type')->comment('0 = general system error, 1 = inventory gateway error, 2 = order error, 3 = order shipment error, 4 = order package error');
            $table->integer('type_subid');
            $table->boolean('been_read');
        });
        Schema::create('system_logs', function (Blueprint $table) {
            $table->text('data');
            $table->dateTime('created');
        });

        Schema::create('system_messages', function (Blueprint $table) {
            $table->integer('id')->index('id');
            $table->string('message', 500);
            $table->dateTime('posted');
        });
        Schema::create('system_tasks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('site_id');
            $table->boolean('type')->comment('0=download update');
            $table->string('type_info')->comment('type = 0: download url');
        });
        Schema::create('system_updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('site_id')->index('syup_site_id');
            $table->string('version', 25);
            $table->tinyInteger('type')->comment('0=download, 1=run update');
            $table->boolean('processing');
        });
        Schema::create('sites_datafeeds', function (Blueprint $table) {
            $table->integer('site_id')->index('sida_site_id');
            $table->integer('datafeed_id');
            $table->boolean('parent_children');
            $table->text('custom_info');
        });

        Schema::rename('specialties', 'account_specialties');
        Schema::rename('account_files', 'mods_account_files');
        Schema::rename('account_ads', 'mods_account_ads');
        Schema::rename('account_ads_clicks', 'mods_account_ads_clicks');
        Schema::rename('account_ads_campaigns', 'mods_account_ads_campaigns');

        Schema::rename('account_certifications', 'mods_account_certifications');
        Schema::rename('account_certifications_files', 'mods_account_certifications_files');

        Schema::rename('trip_flyers', 'mods_trip_flyers');
        Schema::rename('trip_flyers_settings', 'mods_trip_flyers_settings');

        Schema::rename('dates_auto_orderrules', 'mods_dates_auto_orderrules');
        Schema::rename('dates_auto_orderrules_action', 'mods_dates_auto_orderrules_action');
        Schema::rename('dates_auto_orderrules_excludes', 'mods_dates_auto_orderrules_excludes');
        Schema::rename('dates_auto_orderrules_products', 'mods_dates_auto_orderrules_products');

        Schema::rename('resort_details', 'mods_resort_details');
        Schema::rename('resort_details_amenities', 'mods_resort_details_amenities');

        Schema::rename('membership_subscriptions', 'accounts_memberships');
        Schema::rename('membership_levels', 'accounts_membership_levels');
        Schema::rename('membership_attributes', 'accounts_membership_attributes');
        Schema::rename('membership_payment_methods', 'accounts_memberships_payment_methods');
        Schema::rename('membership_levels_settings', 'accounts_membership_levels_settings');
        Schema::rename('membership_levels_attributes', 'accounts_membership_levels_attributes');
        Schema::rename('membership_attributes_sections', 'accounts_membership_attributes_sections');

        Schema::table('orders_products_sentemails', function (Blueprint $table) {
            $table->renameColumn('orders_products_id', 'op_id');
        });
    }
};
