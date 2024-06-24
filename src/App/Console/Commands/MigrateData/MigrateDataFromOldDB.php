<?php

namespace App\Console\Commands\MigrateData;

use Database\Seeders\SupportDepartmentSeeder;
use Doctrine\DBAL\Connection;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountOld;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Orders\Models\Carts\CartItems\CartItemOptionOld;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\DbDumper\Databases\MySql;

class MigrateDataFromOldDB extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'DataMigrate:run {step=1}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a dump file from old database and use it for create data in new database';

  //These tables from old db are not needed in new DB
  private $excludeTable = [
    'migrations',
    'accounts_oldbilling',
    'accounts_oldfitpro',
    'accounts_oldfitproinstructors',
    'accounts_oldmembership',
    'accounts_oldshipping',
    'accounts_oldspecialties',
    'affiliates_oldfitpro',
    'pages-menus_catalogcategories',
    'pages-menus_categories',
    'pages-menus_links',
    'products_resort_dates',
    'products_reviews_oldfitpro',
    'resorts',
    'sites_message_keys',
    'friend_requests_oldfitpro',
    'instructors',
    'orders_products_oldfitpro',
    'articles_views',
    'articles_comments',
    'articles_resources',
    'articles_categories',
    'articles',
    'banners_shown',
    'banners_clicks',
    'banners_images',
    'banners_campaigns',
    'instructors_certfiles',
    'accounts_bulletins',
    'accounts-types_products',
    'accounts-types_categories',
    'accounts-types_restrictordering',
    'accounts_updates',
    'accounts_transactions',
    'accounts-specialties_products',
    'accounts_resourcebox',
    'accounts_programs_accounts',
    'accounts_programs',
    'accounts_advertising_clicks',
    'accounts_advertising_campaigns',
    'accounts_advertising',
    'blog_entry_comments',
    'blog_entry_views',
    'blog_entry',
    'blogs_views',
    'blogs',
    'board_type',
    'board_threads',
    'board_categories',
    'board_thread_entry',
    'board_threads_details',
    'boards',
    'newsletters_sites',
    'newsletters_history',
    'newsletters_subscribers',
    'newsletters',
    'group_users',
    'group_views',
    'group_updates',
    'group_requests',
    'group_bulletins',
    'groups',
    'mods_lookbooks_images_maps',
    'mods_lookbooks_areas_images',
    'mods_lookbooks_images',
    'mods_lookbooks_areas',
    'mods_lookbooks',
    'attributes_packages_sets',
    'attributes_packages',
    'discounts_rules_products',
    'discounts_advantages_products',
    'discounts_rules',
    'discounts_advantages',
    'discounts_old',
    'message_templates_new',
    'resorts_amenities',
    'system_updates',
    'system_tasks',
    'system_messages',
    'system_logs',
    'system_alerts',
    'system_errors',
    'sites_datafeeds',
  ];

  // tables with '0000-00-00%' date/datetime value.
  private $dateTimeNDateField = [
    'accounts_messages' => ['readdate', 'sent'],
    'discount' => ['exp_date', 'start_date'],
    //        'discounts' => ['exp_date', 'start_date'],
    'friends' => ['added'],
    'mods_account_certifications' => ['created', 'updated'],
    'mods_account_certifications_files' => ['uploaded'],
    'orders_customforms' => ['modified'],
    'orders_shipments' => ['ship_date', 'future_ship_date', 'delivery_date', 'last_status_update'],
    'orders_transactions' => ['cc_exp', 'updated', 'voided_date'],
    'photos_albums' => ['updated'],
    'products_details' => ['orders_updated', 'views_updated'],
    'products_options_values' => ['start_date', 'end_date'],
    'products_pricing' => ['published_date'],
    'reports' => ['from_date', 'to_date', 'modified'],
    'wishlists' => ['created'],
    'accounts' => ['account_created', 'account_lastlogin', 'last_verify_attempt_date'],
    'accounts_memberships' => ['cancelled'],
  ];

  // tables with 0 foreign key value.
  private $foreignKeyField = [
    'products' => ['parent_product', 'details_img_id', 'category_img_id', 'default_distributor_id'],
    'discount_advantage' => ['apply_shipping_country', 'apply_shipping_id', 'apply_shipping_distributor'],
    'categories' => ['parent_id'],
    'categories_settings_sites_modulevalues' => ['site_id'],
    'accounts_addressbook' => ['state_id', 'country_id'],
    'accounts_comments' => ['account_id', 'replyto_id'],
    'categories_settings' => ['settings_template_id', 'layout_id'],
    'categories_settings_sites' => ['site_id', 'settings_template_id', 'layout_id', 'module_template_id', 'search_form_id'],
    'categories_settings_templates' => ['settings_template_id', 'layout_id', 'module_template_id', 'search_form_id'],
    'giftregistry_items' => ['parent_product'],
    'menu' => ['parent'],
    'account_specialties' => ['parent_id'],
    'categories_rules' => ['category_id'],
    'categories_rules_attributes' => ['rule_id'],
    'admin_users' => ['level_id', 'account_id'],
    'mods_dates_auto_orderrules_action' => ['criteria_orderingruleid', 'criteria_siteid'],
    'mods_resort_details' => ['fpt_manager_id'],
    'orders_products' => ['parent_product_id', 'registry_item_id'],
    'pages_categories' => ['parent_category_id'],
    'pages_settings_sites' => ['settings_template_id', 'layout_id', 'module_template_id'],
    'pages_settings_templates' => ['settings_template_id', 'layout_id', 'module_template_id'],
    'payment_methods' => ['gateway_id'],
    'products_rules_fulfillment_rules' => ['parent_rule_id'],
    'products_rules_ordering_rules' => ['parent_rule_id'],
    'products_settings' => ['settings_template_id', 'layout_id', 'module_template_id'],
    'products_settings_sites' => ['settings_template_id', 'layout_id', 'module_template_id', 'site_id'],
    'products_settings_templates' => ['settings_template_id', 'layout_id', 'module_template_id'],
    'products_settings_sites_modulevalues' => ['site_id'],
    'accounts_membership_levels' => ['monthly_product_id'],
    'accounts_memberships' => ['membership_id', 'product_id', 'order_id'],
    'accounts_types' => ['discount_level_id', 'loyaltypoints_id', 'membership_level_id', 'affiliate_level_id', 'custom_form_id'],
    'accounts' => ['default_billing_id', 'default_shipping_id', 'affiliate_id', 'cim_profile_id', 'photo_id', 'site_id', 'loyaltypoints_id'],
    'friends_updates' => ['friend_id'],
    'gift_cards_transactions' => ['order_id'],
    'modules_templates' => ['parent_template_id'],
    'mods_account_certifications' => ['account_id'],
    'mods_account_certifications_files' => ['site_id'],
    'options_templates_options' => ['template_id'],
    'orders' => ['account_billing_id', 'account_shipping_id'],
    'orders_activities' => ['order_id'],
    'orders_billing' => ['bill_state_id', 'bill_country_id'],
    'orders_customforms' => ['product_type_id', 'product_id'],
    'orders_shipments' => ['ship_method_id', 'order_status_id'],
    'orders_shipping' => ['ship_state_id', 'ship_country_id'],
    'orders_transactions' => ['account_billing_id', 'gateway_account_id'],
    'orders_transactions_billing' => ['bill_state_id', 'bill_country_id'],
    'pages_settings' => ['layout_id', 'settings_template_id', 'module_template_id'],
    'pages_settings_sites_modulevalues' => ['site_id'],
    'photos_favorites' => ['account_id', 'photo_id'],
    'products_details' => ['type_id', 'brand_id'],
    'products_distributors' => ['distributor_id'],
    'products_log' => ['product_id'],
    'products_options' => ['product_id'],
    'products_options_values' => ['image_id'],
    'products_pricing' => ['site_id', 'pricing_rule_id', 'ordering_rule_id'],
    'products_pricing_temp' => ['site_id', 'pricing_rule_id', 'ordering_rule_id'],
    'products_types_attributes_sets' => ['set_id'],
    'saved_cart' => ['account_id'],
    'saved_cart_items' => ['parent_cart_id', 'parent_product', 'registry_item_id', 'accessory_field_id', 'distributor_id'],
    'saved_order_information' => ['account_billing_id', 'account_shipping_id', 'bill_state_id', 'bill_country_id', 'ship_state_id', 'ship_country_id', 'payment_method_id', 'shipping_method_id'],
    'sites_payment_methods' => ['gateway_account_id'],
    'sites_settings' => ['default_category_search_form_id'],
    'wishlists_items' => ['parent_wishlist_items_id', 'wishlist_id', 'product_id', 'parent_product', 'accessory_field_id'],
    'accounts_addtl_fields' => ['section_id', 'form_id'],
  ];

  // tables with -1 foreign key value.
  private $otherField = [
    'accounts_cims' => ['account_id'],
    'accounts_messages' => ['to_id', 'replied_id', 'from_id'],
  ];

  // tables with invalid or 0 foreign key value.
  private $foreignKeyCheckCorrection = [
    'accounts' => [
      'affiliates' => 'affiliate_id',
      'photos' => 'photo_id',
      'sites' => 'site_id',
      'loyaltypoints' => 'loyaltypoints_id',
    ],
    'accounts_addressbook' => [
      'accounts' => 'account_id',
    ],
    'admin_users_distributors' => [
      'admin_users' => 'user_id',
    ],
    'admin_users' => [
      'accounts' => 'account_id',
    ],
    'accounts_comments' => [
      'accounts' => 'account_id',
      'accounts' => 'replyto_id',
    ],
    'accounts_addtl_fields' => [
      'accounts' => 'account_id',
    ],
    'accounts_cims' => [
      'accounts' => 'account_id',
      'cim_profile' => 'cim_profile_id',
    ],
    'accounts_discounts_used' => [
      'accounts' => 'account_id',
      'discount' => 'discount_id',
    ],
    'accounts_memberships' => [
      'accounts' => 'account_id',
    ],
    'friend_requests' => [
      'accounts' => 'account_id',
      'accounts11' => 'friend_id',
    ],
    'accounts_messages' => [
      'accounts_messages_headers' => 'header_id',
      'accounts' => 'replied_id',
      'accounts11' => 'to_id',
      'accounts22' => 'from_id',
    ],
    'accounts_onmind' => [
      'accounts' => 'account_id',
    ],
    'accounts_onmind_comments' => [
      'accounts' => 'account_id',
      'accounts_onmind' => 'onmind_id',
    ],
    'accounts_onmind_likes' => [
      'accounts' => 'account_id',
      'accounts_onmind' => 'onmind_id',
    ],
    'accounts_specialties' => [
      'accounts' => 'account_id',
      'account_specialties' => 'specialty_id',
    ],
    'accounts_templates_sent' => [
      'accounts' => 'account_id',
      'message_templates' => 'template_id',
    ],
    'accounts_views' => [
      'accounts' => 'account_id',
    ],
    'admin_emails_sent' => [
      'accounts' => 'account_id',
      'message_templates' => 'template_id',
      'orders' => 'order_id',
    ],
    'affiliates' => [
      'accounts' => 'account_id',
      'states' => 'state_id',
      'affiliates_levels' => 'affiliate_level_id',
    ],
    'affiliates_referrals' => [
      'orders' => 'order_id',
    ],
    'categories_featured' => [
      'categories' => 'category_id',
    ],
    'categories_products_assn' => [
      'categories' => 'category_id',
    ],
    'categories_rules_attributes' => [
      'attributes_options' => 'value_id',
    ],
    'categories_settings' => [
      'categories' => 'category_id',
      'modules_templates' => 'module_template_id',
    ],

    'categories_settings_sites_modulevalues' => [
      'categories' => 'category_id',
    ],
    'cim_profile_paymentprofile' => [
      'cim_profile' => 'profile_id',
    ],
    'discount_advantage' => [
      'accounts_addressbook' => 'apply_shipping_id',
    ],
    'discount_advantage_products' => [
      'discount_advantage' => 'advantage_id',
    ],
    'discount_advantage_producttypes' => [
      'discount_advantage' => 'advantage_id',
    ],
    'discount_rule_condition_membershiplevels' => [
      'discount_rule_condition' => 'condition_id',
    ],
    'events' => [
      'photos' => 'photo',
    ],
    'friends' => [
      'accounts' => 'account_id',
      'accounts11' => 'friend_id',
    ],
    'gift_cards_transactions' => [
      'users' => 'admin_user_id',
    ],
    'mods_account_ads_clicks' => [
      'mods_account_ads' => 'ad_id',
    ],
    'mods_account_ads' => [
      'accounts' => 'account_id',
    ],
    'mods_dates_auto_orderrules_excludes' => [
      'mods_dates_auto_orderrules' => 'dao_id',
    ],
    'mods_trip_flyers' => [
      'orders_products' => 'orders_products_id',
      'photos' => 'photo_id',
    ],
    'mods_trip_flyers_settings' => [
      'photos' => 'photo_id',
      'accounts' => 'account_id',
    ],
    'modules_templates_modules' => [
      'modules_templates' => 'template_id',
      'modules' => 'module_id',
    ],
    'modules_templates_sections' => [
      'modules_templates' => 'template_id',
    ],
    'orders_activities' => [
      'orders' => 'order_id',
    ],
    'orders' => [
      'accounts' => 'account_id',
    ],
    'orders_discounts' => [
      'discount' => 'discount_id',
      'discount_advantage' => 'advantage_id',
    ],
    'orders_packages' => [
      'orders_shipments' => 'shipment_id',
    ],
    'accessories_fields_products' => [
      'products' => 'product_id',
    ],
    'orders_products_discounts' => [
      'discount' => 'discount_id',
      'discount_advantage' => 'advantage_id',
    ],
    'orders_products_options' => [
      'orders_products' => 'orders_products_id',
      'products_options_values' => 'value_id',
    ],
    'orders_products_sentemails' => [
      'orders_products' => 'op_id',
    ],
    'orders_shipments' => [
      'distributors' => 'distributor_id',
    ],
    'orders_transactions' => [
      'orders' => 'order_id',
      'cim_profile_paymentprofile' => 'cim_payment_profile_id',
    ],
    'orders_transactions_billing' => [
      'orders_transactions' => 'orders_transactions_id',
    ],
    'pages_settings_sites' => [
      'pages' => 'page_id',
      'sites' => 'site_id',
    ],
    'pages_settings_sites_modulevalues' => [
      'modules_fields' => 'field_id',
    ],
    'photos' => [
      'accounts' => 'addedby',
      'photos_albums' => 'album',
    ],
    'photos_comments' => [
      'accounts' => 'account_id',
      'photos' => 'photo_id',
    ],
    'products_attributes' => [
      'attributes_options' => 'option_id',
    ],
    'products_details' => [
      'categories' => 'default_category_id',
    ],
    'products_options_values' => [
      'products_options' => 'option_id',
    ],
    'products_pricing_temp' => [
      'products_rules_ordering' => 'ordering_rule_id',
    ],
    'products_rules_ordering_conditions' => [
      'products_rules_ordering_rules' => 'rule_id',
    ],
    'products_settings_sites_modulevalues' => [
      'modules_fields' => 'field_id',
    ],
    'products_settings_templates_modulevalues' => [
      'modules_fields' => 'field_id',
    ],
    'saved_cart_items_customfields' => [
      'modules_fields' => 'field_id',
      'custom_forms_sections' => 'section_id',
      'custom_forms' => 'form_id',
    ],
    'search_forms_fields' => [
      'search_forms' => 'search_id',
    ],
    'shipping_carriers' => [
      'shipping_gateways' => 'gateway_id',
    ],
    'sites_message_templates' => [
      'sites' => 'site_id',
    ],
    'sites_packingslip' => [
      'sites' => 'site_id',
    ],
    'sites_settings_modulevalues' => [
      'modules_fields' => 'field_id',
    ],
    'sites_tax_rules' => [
      'tax_rules' => 'tax_rule_id',
    ],
    'sites_themes' => [
      'sites' => 'site_id',
    ],
    'tax_rules_locations' => [
      'tax_rules' => 'tax_rule_id',
      'countries' => 'country_id',
    ],
    'tax_rules_product_types' => [
      'tax_rules' => 'tax_rule_id',
    ],
    'wishlists_items' => [
      'wishlists_items' => 'parent_wishlist_items_id',
    ],
    'wishlists_items_options' => [
      'wishlists_items' => 'wishlists_item_id',
    ],
    'mods_account_files' => [
      'accounts' => 'account_id',
    ],
    'photos_favorites' => [
      'photos' => 'photo_id',
      'accounts' => 'account_id',
    ],
    'saved_order' => [
      'accounts' => 'account_id',
    ],
    'wishlists' => [
      'accounts' => 'account_id',
    ],
    'mods_resort_details_amenities' => [
      'mods_resort_details' => 'resort_details_id',
      'mod_resort_details_amenities' => 'amenity_id',
    ],
    'orders_shipments_labels' => [
      'orders_packages' => 'package_id',
    ],
    'saved_cart_items_options' => [
      'saved_cart_items' => 'saved_cart_item_id',
    ],
  ];

  //This table rows need to delted if foreign key is 0 or invalid as foreign key is also primary key of this table
  private $deleteRowTable = [
    'sites_message_templates' => 'site_id',
    'wishlists_items_options' => 'wishlists_item_id',
    'categories_settings' => 'category_id',
    'sites_packingslip' => 'site_id',
    'orders_transactions_billing' => 'orders_transactions_id',
    'accounts' => 'account_id',
    'admin_users' => 'account_id',
    'admin_users_distributors' => 'user_id',
    'mods_account_files' => 'account_id',
    'mods_trip_flyers_settings' => 'account_id',
    'photos_favorites' => 'account_id',
    'saved_order' => 'account_id',
    'wishlists' => 'account_id',
    'mods_resort_details_amenities' => 'resort_details_id',
    'orders_shipments_labels' => 'package_id',
    'photos_comments' => 'photo_id',
    'saved_cart_items_options' => 'saved_cart_item_id'
  ];

  /**
   * Execute the console command.
   *
   * @return int
   */

  public function __construct()
  {
    //    DB::getDoctrineSchemaManager()
    //        ->getDatabasePlatform()
    //        ->registerDoctrineTypeMapping('enum', 'string');
    parent::__construct();
  }

  public function handle()
  {
    $progressbar = $this->output->createProgressBar(9);
    $progressbar->start();

    $startFromStep = $this->argument('step');

    if ($startFromStep == 1) {
      $this->output->write('<info> Creating Db structure from Mysql Dump. </info>');
      $this->changeSchemaName();
      Artisan::call('migrate:fresh --path=database/schema/mysql-schema.sql');
      $this->RestoreSchemaNameSchemaName();
    }
    $progressbar->advance();

    if ($startFromStep <= 2) {
      //Dump previous database. I am using db you send me to create it.(local db mac)
      $this->output->write('<info> Creating Dump File Of previous Data </info>');
      $this->dumpOldDb();
      //sleep(1);
    }
    $progressbar->advance();


    if ($startFromStep <= 3) {
      //Insert data into new DB (docker mysql)
      $this->output->write('<info> Importing Data To New DB </info>');
      $output = null;
      $exitCode = null;
      exec('mysql -u '
        . config('database.connections.mysql.username')
        . ' -p'
        . config('database.connections.mysql.password')
        . ' -h '
        . config('database.connections.mysql.host')
        . ' '
        . config('database.connections.mysql.database')
        . ' < old_db.sql 2>&1', $output, $exitCode);
      if ($exitCode !== 0) {
        $this->output->write('<error> MySQL import failed: ' . implode("\n", $output) . ' </error>');
      } else {
        $progressbar->advance();
      }
    }

    if ($startFromStep <= 4) {
      $this->output->write('<info> Run Initial Migration For Data Correction </info>');
      $this->removeInvalidAccount();
      $this->dateTimeAndDateFieldCorrectionBefore();
      //Make the date and datetime field null for further correction
      Artisan::call('migrate --path=database/migrations/1_data_correction');
      $this->otherCorrection();
      $this->dateTimeAndDateFieldCorrection();
    }
    $progressbar->advance();

    if ($startFromStep <= 5) {
      $this->output->write('<info> Run Migration To Change The DB Structure </info>');
      Artisan::call('migrate --path=database/migrations/3_standard');
    }
    $progressbar->advance();

    if ($startFromStep <= 6) {
      $this->output->write('<info> Run Foreign Key Data Correction </info>');
      $this->foreignKeyDataCorrection();
    }
    $progressbar->advance();

    if ($startFromStep <= 7) {
      $this->output->write('<info> Foreign Key Migration </info>');
      Artisan::call('migrate --path=database/migrations/4_renames');
    }
    $progressbar->advance();

    if ($startFromStep <= 8) {
      $this->output->write('<info> Html Decode </info>');
      $this->htmlDecodeData();
    }
    $progressbar->advance();

    // $this->output->write('<info> Change Float/Decimal Field to integer </info>');
    // $this->changeDecimalToInteger();
    //$progressbar->advance();

    if ($startFromStep <= 9) {
      $this->output->write('<info> Start Cart Refactor </info>');
      $this->cartRefactor();
      $supportDepartmentSeeder = new SupportDepartmentSeeder();
      $supportDepartmentSeeder->run();
    }
    $progressbar->advance();

    if ($startFromStep <= 10) {
      Artisan::call('migrate --path=database/migrations/5_june23');
      $this->output->write('<info> Run Later Migrations </info>');
      Artisan::call('migrate');
    }

    $progressbar->finish();
  }

  private function cartRefactor()
  {
    $progressbar = $this->output->createProgressBar(3);

    $progressbar->start();
    $this->output->write('<info>Update Foreign Key Data</info>');
    $this->updateForeignData();
    $progressbar->advance();

    $this->output->write('<info>Run Migrate</info>');
    Artisan::call('migrate');
    $progressbar->advance();

    $this->output->write('<info>Modify Data/info>');
    $this->modifyAndDropCartItemOption();
    $this->convertCartDiscountCodes();
    $this->covertCartAvailability();
    Schema::dropIfExists('cart_items_options_customvalues');

    $progressbar->finish();
  }

  private function updateForeignData()
  {
    Schema::table(CartItem::Table(), function (Blueprint $table) {
      $table->unsignedBigInteger('required')->nullable()->change();
      $table->unsignedBigInteger('accessory_link_actions')
        ->nullable()
        ->change();
    });
    $child_data = DB::select('select id from `cart_items`');
    $ids = [];
    foreach ($child_data as $value) {
      $ids[] = $value->id;
    }

    //updating because the array was empty for me and caused the query to fail
    $query = 'UPDATE `cart_items` set `parent_cart_id` = NULL where `parent_cart_id` is not null';
    if (count($ids)) {
      $query .= ' and `parent_cart_id` not in (' . implode(',', $ids) . ')';
    }

    DB::statement($query);

    $query = 'UPDATE `cart_items` set `required` = NULL where `required` is not null';
    if (count($ids)) {
      $query .= ' and `required` not in (' . implode(',', $ids) . ')';
    }

    DB::statement($query);

    $query = 'UPDATE `cart_items` set `accessory_link_actions` = NULL where `accessory_link_actions` is not null';
    if (count($ids)) {
      $query .= ' and `accessory_link_actions` not in (' . implode(',', $ids) . ')';
    }

    DB::statement($query);
  }

  private function modifyAndDropCartItemOption()
  {
    $cart_item_options = CartItemOptionOld::all();
    foreach ($cart_item_options as $cart_item_option) {
      $options = $cart_item_option['options_json'];
      foreach ($options as $option) {
        CartItemOption::create(
          [
            'item_id' => $cart_item_option['cart_item_id'],
            'option_value_id' => $option[0],
          ]
        );
      }
    }
    Schema::dropIfExists('cart_items_options');
  }

  private function convertCartDiscountCodes()
  {
    $cartDiscounts = CartDiscountOld::all();
    foreach ($cartDiscounts as $cartDiscount) {
      $discountCodes = $cartDiscount['applied_codes_json'];
      foreach ($discountCodes as $discountCode) {
        $discountCondition = DiscountCondition::where('required_code', $discountCode)->first();
        if ($discountCondition) {
          CartDiscountCode::create(
            [
              'cart_id' => $cartDiscount['cart_id'],
              'code' => $discountCode,
              'condition_id' => $discountCondition->id,
            ]
          );
        }
      }
    }
  }

  private function covertCartAvailability()
  {
    $siteSettings = SiteSettings::all();
    foreach ($siteSettings as $siteSetting) {
      if ($siteSetting->cart_allowavailability) {
        $jsonDecoded = html_entity_decode($siteSetting->cart_allowavailability);
        $json = json_decode($jsonDecoded, true);
        if ($json !== null) {
          $siteSetting->cart_allowavailability = $json;
          $siteSetting->save();
        }
      }
    }
  }

  private function changeSchemaName()
  {
    rename('database/schema/mysql-schema.sql', 'database/schema/mysql-schema.back.sql');
    rename('database/schema/mysql-schema.old-system.sql', 'database/schema/mysql-schema.sql');
  }

  private function RestoreSchemaNameSchemaName()
  {
    rename('database/schema/mysql-schema.sql', 'database/schema/mysql-schema.old-system.sql');
    rename('database/schema/mysql-schema.back.sql', 'database/schema/mysql-schema.sql');
  }

  private function dumpOldDb($file_name = 'old_db')
  {

    MySql::create()
      ->doNotCreateTables()
      ->doNotUseColumnStatistics()
      ->excludeTables($this->excludeTable)
      ->addExtraOptionAfterDbName('--skip-triggers')
      ->setDbName(config('database.connections.legacy.database'))
      ->setPort(3306) //config('database.connections.legacy.port', '3306'))
      ->setHost(config('database.connections.legacy.host', 'legacy_mysql'))
      ->setUserName(config('database.connections.legacy.username', 'root'))
      ->setPassword(config('database.connections.legacy.password', ''))
      ->dumpToFile($file_name . '.sql');
  }

  private function removeInvalidAccount()
  {
    DB::statement('DELETE FROM `accounts` where `id` = -1');
  }

  private function otherCorrection()
  {
    foreach ($this->otherField as $table => $fields) {
      foreach ($fields as $field) {
        DB::statement("UPDATE `{$table}` set `{$field}` = NULL where `{$field}` = -1");
      }
    }

    DB::statement("UPDATE `products_details` set `attributes`= REPLACE(REPLACE(CONCAT('[', REPLACE(`product_attributes`, '|', ','), ']'), '[,', '['), ',]',']')");
  }

  private function createFunctionMysql()
  {
    DB::statement('SET GLOBAL log_bin_trust_function_creators =1');
    DB::statement('DROP FUNCTION IF EXISTS `HTML_UnEncode`');
    $fnsql = "CREATE FUNCTION `HTML_UnEncode`(X Text) RETURNS Text
        BEGIN
        DECLARE TextString LongText ;
        SET TextString = X ;

        IF INSTR( X , '&quot;' )
        THEN SET TextString = REPLACE(TextString, '&quot;','\"');
        END IF;

        IF INSTR( X , '&apos;' )
        THEN SET TextString = REPLACE(TextString, '&apos;','\"') ;
        END IF ;

        #ampersand
        IF INSTR( X , '&amp;' )
        THEN SET TextString = REPLACE(TextString, '&amp;','&') ;
        END IF ;

        #less-than
        IF INSTR( X , '&lt;' )
        THEN SET TextString = REPLACE(TextString, '&lt;','<') ;
        END IF ;

        #greater-than
        IF INSTR( X , '&gt;' )
        THEN SET TextString = REPLACE(TextString, '&gt;','>') ;
        END IF ;

        #non-breaking space
        IF INSTR( X , '&nbsp;' )
        THEN SET TextString = REPLACE(TextString, '&nbsp;',' ') ;
        END IF ;

        #inverted exclamation mark
        IF INSTR( X , '&iexcl;' )
        THEN SET TextString = REPLACE(TextString, '&iexcl;','¡') ;
        END IF ;

        #cent
        IF INSTR( X , '&cent;' )
        THEN SET TextString = REPLACE(TextString, '&cent;','¢') ;
        END IF ;

        #pound
        IF INSTR( X , '&pound;' )
        THEN SET TextString = REPLACE(TextString, '&pound;','£') ;
        END IF ;

        #currency
        IF INSTR( X , '&curren;' )
        THEN SET TextString = REPLACE(TextString, '&curren;','¤') ;
        END IF ;

        #yen
        IF INSTR( X , '&yen;' )
        THEN SET TextString = REPLACE(TextString, '&yen;','¥') ;
        END IF ;

        #broken vertical bar
        IF INSTR( X , '&brvbar;' )
        THEN SET TextString = REPLACE(TextString, '&brvbar;','¦') ;
        END IF ;

        #section
        IF INSTR( X , '&sect;' )
        THEN SET TextString = REPLACE(TextString, '&sect;','§') ;
        END IF ;

        #spacing diaeresis
        IF INSTR( X , '&uml;' )
        THEN SET TextString = REPLACE(TextString, '&uml;','¨') ;
        END IF ;

        #copyright
        IF INSTR( X , '&copy;' )
        THEN SET TextString = REPLACE(TextString, '&copy;','©') ;
        END IF ;

        #feminine ordinal indicator
        IF INSTR( X , '&ordf;' )
        THEN SET TextString = REPLACE(TextString, '&ordf;','ª') ;
        END IF ;

        #angle quotation mark (left)
        IF INSTR( X , '&laquo;' )
        THEN SET TextString = REPLACE(TextString, '&laquo;','«') ;
        END IF ;

        #negation
        IF INSTR( X , '&not;' )
        THEN SET TextString = REPLACE(TextString, '&not;','¬') ;
        END IF ;

        #soft hyphen
        IF INSTR( X , '&shy;' )
        THEN SET TextString = REPLACE(TextString, '&shy;','­') ;
        END IF ;

        #registered trademark
        IF INSTR( X , '&reg;' )
        THEN SET TextString = REPLACE(TextString, '&reg;','®') ;
        END IF ;

        #spacing macron
        IF INSTR( X , '&macr;' )
        THEN SET TextString = REPLACE(TextString, '&macr;','¯') ;
        END IF ;

        #degree
        IF INSTR( X , '&deg;' )
        THEN SET TextString = REPLACE(TextString, '&deg;','°') ;
        END IF ;

        #plus-or-minus
        IF INSTR( X , '&plusmn;' )
        THEN SET TextString = REPLACE(TextString, '&plusmn;','±') ;
        END IF ;

        #superscript 2
        IF INSTR( X , '&sup2;' )
        THEN SET TextString = REPLACE(TextString, '&sup2;','²') ;
        END IF ;

        #superscript 3
        IF INSTR( X , '&sup3;' )
        THEN SET TextString = REPLACE(TextString, '&sup3;','³') ;
        END IF ;

        #spacing acute
        IF INSTR( X , '&acute;' )
        THEN SET TextString = REPLACE(TextString, '&acute;','´') ;
        END IF ;

        #micro
        IF INSTR( X , '&micro;' )
        THEN SET TextString = REPLACE(TextString, '&micro;','µ') ;
        END IF ;

        #paragraph
        IF INSTR( X , '&para;' )
        THEN SET TextString = REPLACE(TextString, '&para;','¶') ;
        END IF ;

        #middle dot
        IF INSTR( X , '&middot;' )
        THEN SET TextString = REPLACE(TextString, '&middot;','·') ;
        END IF ;

        #spacing cedilla
        IF INSTR( X , '&cedil;' )
        THEN SET TextString = REPLACE(TextString, '&cedil;','¸') ;
        END IF ;

        #superscript 1
        IF INSTR( X , '&sup1;' )
        THEN SET TextString = REPLACE(TextString, '&sup1;','¹') ;
        END IF ;

        #masculine ordinal indicator
        IF INSTR( X , '&ordm;' )
        THEN SET TextString = REPLACE(TextString, '&ordm;','º') ;
        END IF ;

        #angle quotation mark (right)
        IF INSTR( X , '&raquo;' )
        THEN SET TextString = REPLACE(TextString, '&raquo;','»') ;
        END IF ;

        #fraction 1/4
        IF INSTR( X , '&frac14;' )
        THEN SET TextString = REPLACE(TextString, '&frac14;','¼') ;
        END IF ;

        #fraction 1/2
        IF INSTR( X , '&frac12;' )
        THEN SET TextString = REPLACE(TextString, '&frac12;','½') ;
        END IF ;

        #fraction 3/4
        IF INSTR( X , '&frac34;' )
        THEN SET TextString = REPLACE(TextString, '&frac34;','¾') ;
        END IF ;

        #inverted question mark
        IF INSTR( X , '&iquest;' )
        THEN SET TextString = REPLACE(TextString, '&iquest;','¿') ;
        END IF ;

        #multiplication
        IF INSTR( X , '&times;' )
        THEN SET TextString = REPLACE(TextString, '&times;','×') ;
        END IF ;

        #division
        IF INSTR( X , '&divide;' )
        THEN SET TextString = REPLACE(TextString, '&divide;','÷') ;
        END IF ;

        #capital a, grave accent
        IF INSTR( X , '&Agrave;' )
        THEN SET TextString = REPLACE(TextString, '&Agrave;','À') ;
        END IF ;

        #capital a, acute accent
        IF INSTR( X , '&Aacute;' )
        THEN SET TextString = REPLACE(TextString, '&Aacute;','Á') ;
        END IF ;

        #capital a, circumflex accent
        IF INSTR( X , '&Acirc;' )
        THEN SET TextString = REPLACE(TextString, '&Acirc;','Â') ;
        END IF ;

        #capital a, tilde
        IF INSTR( X , '&Atilde;' )
        THEN SET TextString = REPLACE(TextString, '&Atilde;','Ã') ;
        END IF ;

        #capital a, umlaut mark
        IF INSTR( X , '&Auml;' )
        THEN SET TextString = REPLACE(TextString, '&Auml;','Ä') ;
        END IF ;

        #capital a, ring
        IF INSTR( X , '&Aring;' )
        THEN SET TextString = REPLACE(TextString, '&Aring;','Å') ;
        END IF ;

        #capital ae
        IF INSTR( X , '&AElig;' )
        THEN SET TextString = REPLACE(TextString, '&AElig;','Æ') ;
        END IF ;

        #capital c, cedilla
        IF INSTR( X , '&Ccedil;' )
        THEN SET TextString = REPLACE(TextString, '&Ccedil;','Ç') ;
        END IF ;

        #capital e, grave accent
        IF INSTR( X , '&Egrave;' )
        THEN SET TextString = REPLACE(TextString, '&Egrave;','È') ;
        END IF ;

        #capital e, acute accent
        IF INSTR( X , '&Eacute;' )
        THEN SET TextString = REPLACE(TextString, '&Eacute;','É') ;
        END IF ;

        #capital e, circumflex accent
        IF INSTR( X , '&Ecirc;' )
        THEN SET TextString = REPLACE(TextString, '&Ecirc;','Ê') ;
        END IF ;

        #capital e, umlaut mark
        IF INSTR( X , '&Euml;' )
        THEN SET TextString = REPLACE(TextString, '&Euml;','Ë') ;
        END IF ;

        #capital i, grave accent
        IF INSTR( X , '&Igrave;' )
        THEN SET TextString = REPLACE(TextString, '&Igrave;','Ì') ;
        END IF ;

        #capital i, acute accent
        IF INSTR( X , '&Iacute;' )
        THEN SET TextString = REPLACE(TextString, '&Iacute;','Í') ;
        END IF ;

        #capital i, circumflex accent
        IF INSTR( X , '&Icirc;' )
        THEN SET TextString = REPLACE(TextString, '&Icirc;','Î') ;
        END IF ;

        #capital i, umlaut mark
        IF INSTR( X , '&Iuml;' )
        THEN SET TextString = REPLACE(TextString, '&Iuml;','Ï') ;
        END IF ;

        #capital eth, Icelandic
        IF INSTR( X , '&ETH;' )
        THEN SET TextString = REPLACE(TextString, '&ETH;','Ð') ;
        END IF ;

        #capital n, tilde
        IF INSTR( X , '&Ntilde;' )
        THEN SET TextString = REPLACE(TextString, '&Ntilde;','Ñ') ;
        END IF ;

        #capital o, grave accent
        IF INSTR( X , '&Ograve;' )
        THEN SET TextString = REPLACE(TextString, '&Ograve;','Ò') ;
        END IF ;

        #capital o, acute accent
        IF INSTR( X , '&Oacute;' )
        THEN SET TextString = REPLACE(TextString, '&Oacute;','Ó') ;
        END IF ;

        #capital o, circumflex accent
        IF INSTR( X , '&Ocirc;' )
        THEN SET TextString = REPLACE(TextString, '&Ocirc;','Ô') ;
        END IF ;

        #capital o, tilde
        IF INSTR( X , '&Otilde;' )
        THEN SET TextString = REPLACE(TextString, '&Otilde;','Õ') ;
        END IF ;

        #capital o, umlaut mark
        IF INSTR( X , '&Ouml;' )
        THEN SET TextString = REPLACE(TextString, '&Ouml;','Ö') ;
        END IF ;

        #capital o, slash
        IF INSTR( X , '&Oslash;' )
        THEN SET TextString = REPLACE(TextString, '&Oslash;','Ø') ;
        END IF ;

        #capital u, grave accent
        IF INSTR( X , '&Ugrave;' )
        THEN SET TextString = REPLACE(TextString, '&Ugrave;','Ù') ;
        END IF ;

        #capital u, acute accent
        IF INSTR( X , '&Uacute;' )
        THEN SET TextString = REPLACE(TextString, '&Uacute;','Ú') ;
        END IF ;

        #capital u, circumflex accent
        IF INSTR( X , '&Ucirc;' )
        THEN SET TextString = REPLACE(TextString, '&Ucirc;','Û') ;
        END IF ;

        #capital u, umlaut mark
        IF INSTR( X , '&Uuml;' )
        THEN SET TextString = REPLACE(TextString, '&Uuml;','Ü') ;
        END IF ;

        #capital y, acute accent
        IF INSTR( X , '&Yacute;' )
        THEN SET TextString = REPLACE(TextString, '&Yacute;','Ý') ;
        END IF ;

        #capital THORN, Icelandic
        IF INSTR( X , '&THORN;' )
        THEN SET TextString = REPLACE(TextString, '&THORN;','Þ') ;
        END IF ;

        #small sharp s, German
        IF INSTR( X , '&szlig;' )
        THEN SET TextString = REPLACE(TextString, '&szlig;','ß') ;
        END IF ;

        #small a, grave accent
        IF INSTR( X , '&agrave;' )
        THEN SET TextString = REPLACE(TextString, '&agrave;','à') ;
        END IF ;

        #small a, acute accent
        IF INSTR( X , '&aacute;' )
        THEN SET TextString = REPLACE(TextString, '&aacute;','á') ;
        END IF ;

        #small a, circumflex accent
        IF INSTR( X , '&acirc;' )
        THEN SET TextString = REPLACE(TextString, '&acirc;','â') ;
        END IF ;

        #small a, tilde
        IF INSTR( X , '&atilde;' )
        THEN SET TextString = REPLACE(TextString, '&atilde;','ã') ;
        END IF ;

        #small a, umlaut mark
        IF INSTR( X , '&auml;' )
        THEN SET TextString = REPLACE(TextString, '&auml;','ä') ;
        END IF ;

        #small a, ring
        IF INSTR( X , '&aring;' )
        THEN SET TextString = REPLACE(TextString, '&aring;','å') ;
        END IF ;

        #small ae
        IF INSTR( X , '&aelig;' )
        THEN SET TextString = REPLACE(TextString, '&aelig;','æ') ;
        END IF ;

        #small c, cedilla
        IF INSTR( X , '&ccedil;' )
        THEN SET TextString = REPLACE(TextString, '&ccedil;','ç') ;
        END IF ;

        #small e, grave accent
        IF INSTR( X , '&egrave;' )
        THEN SET TextString = REPLACE(TextString, '&egrave;','è') ;
        END IF ;

        #small e, acute accent
        IF INSTR( X , '&eacute;' )
        THEN SET TextString = REPLACE(TextString, '&eacute;','é') ;
        END IF ;

        #small e, circumflex accent
        IF INSTR( X , '&ecirc;' )
        THEN SET TextString = REPLACE(TextString, '&ecirc;','ê') ;
        END IF ;

        #small e, umlaut mark
        IF INSTR( X , '&euml;' )
        THEN SET TextString = REPLACE(TextString, '&euml;','ë') ;
        END IF ;

        #small i, grave accent
        IF INSTR( X , '&igrave;' )
        THEN SET TextString = REPLACE(TextString, '&igrave;','ì') ;
        END IF ;

        #small i, acute accent
        IF INSTR( X , '&iacute;' )
        THEN SET TextString = REPLACE(TextString, '&iacute;','í') ;
        END IF ;

        #small i, circumflex accent
        IF INSTR( X , '&icirc;' )
        THEN SET TextString = REPLACE(TextString, '&icirc;','î') ;
        END IF ;

        #small i, umlaut mark
        IF INSTR( X , '&iuml;' )
        THEN SET TextString = REPLACE(TextString, '&iuml;','ï') ;
        END IF ;

        #small eth, Icelandic
        IF INSTR( X , '&eth;' )
        THEN SET TextString = REPLACE(TextString, '&eth;','ð') ;
        END IF ;

        #small n, tilde
        IF INSTR( X , '&ntilde;' )
        THEN SET TextString = REPLACE(TextString, '&ntilde;','ñ') ;
        END IF ;

        #small o, grave accent
        IF INSTR( X , '&ograve;' )
        THEN SET TextString = REPLACE(TextString, '&ograve;','ò') ;
        END IF ;

        #small o, acute accent
        IF INSTR( X , '&oacute;' )
        THEN SET TextString = REPLACE(TextString, '&oacute;','ó') ;
        END IF ;

        #small o, circumflex accent
        IF INSTR( X , '&ocirc;' )
        THEN SET TextString = REPLACE(TextString, '&ocirc;','ô') ;
        END IF ;

        #small o, tilde
        IF INSTR( X , '&otilde;' )
        THEN SET TextString = REPLACE(TextString, '&otilde;','õ') ;
        END IF ;

        #small o, umlaut mark
        IF INSTR( X , '&ouml;' )
        THEN SET TextString = REPLACE(TextString, '&ouml;','ö') ;
        END IF ;

        #small o, slash
        IF INSTR( X , '&oslash;' )
        THEN SET TextString = REPLACE(TextString, '&oslash;','ø') ;
        END IF ;

        #small u, grave accent
        IF INSTR( X , '&ugrave;' )
        THEN SET TextString = REPLACE(TextString, '&ugrave;','ù') ;
        END IF ;

        #small u, acute accent
        IF INSTR( X , '&uacute;' )
        THEN SET TextString = REPLACE(TextString, '&uacute;','ú') ;
        END IF ;

        #small u, circumflex accent
        IF INSTR( X , '&ucirc;' )
        THEN SET TextString = REPLACE(TextString, '&ucirc;','û') ;
        END IF ;

        #small u, umlaut mark
        IF INSTR( X , '&uuml;' )
        THEN SET TextString = REPLACE(TextString, '&uuml;','ü') ;
        END IF ;

        #small y, acute accent
        IF INSTR( X , '&yacute;' )
        THEN SET TextString = REPLACE(TextString, '&yacute;','ý') ;
        END IF ;

        #small thorn, Icelandic
        IF INSTR( X , '&thorn;' )
        THEN SET TextString = REPLACE(TextString, '&thorn;','þ') ;
        END IF ;

        #small y, umlaut mark
        IF INSTR( X , '&yuml;' )
        THEN SET TextString = REPLACE(TextString, '&yuml;','ÿ') ;
        END IF ;

        RETURN TextString ;

        END";
    DB::statement($fnsql);
  }

  private function htmlDecodeData()
  {
    $propertyName = "Tables_in_" . config('database.connections.mysql.database');
    $this->output->write('<info>Finding Number of Field needs to convert. Start htmldecode</info>');
    $tables = DB::select('SHOW TABLES');
    $total = 0;
    foreach ($tables as $table) {
      $fields = Schema::getColumnListing($table->{$propertyName});
      foreach ($fields as $value) {
        $field_type = Schema::getColumnType($table->{$propertyName}, $value);
        if ($field_type === 'text') {
          $total += 1;
        }
      }
    }
    $progressbar = $this->output->createProgressBar($total + 1);
    $progressbar->start();
    $this->output->write('<info> Creating HTML_UnEncode Function</info>');
    /*
        *******IMPORTANT*******
        **It will create a function in mysql for HTML_UnEncode**
        **Before Create this function We need to GRANT ALL PRIVILEGES to 'sail'(DB_USERNAME).**
        **Step to Do That**
        1. Run this command in sail project folder : docker-compose exec mysql bash
        2. execute the mysql -u root -p command (provide the default password password)
        3. then executes GRANT ALL PRIVILEGES ON *.* TO 'sail'@'%';
        4. FLUSH PRIVILEGES;
        */

    $this->createFunctionMysql();
    $progressbar->advance();

    foreach ($tables as $table) {
      $fields = Schema::getColumnListing($table->{$propertyName});
      foreach ($fields as $value) {
        $field_type = Schema::getColumnType($table->{$propertyName}, $value);
        if ($field_type === 'text') {
          sleep(2);
          $this->output->write('<info> Table -- ' . $table->{$propertyName} . ' Field--' . $value . '</info>');
          DB::statement("UPDATE `{$table->{$propertyName}}` set `{$value}` = HTML_UnEncode(`{$value}`) where `{$value}` != '' and `{$value}` is not null");
          $progressbar->advance();
        }
      }
    }
  }

  private function dateTimeAndDateFieldCorrectionBefore()
  {
    //@fahim - why are we setting these to 1971?  why not just run migration to make the fields nullable and then set them to null?
    //it appears you're setting it to null later anyway, i'm unclear why this step is needed?

    //It's a hack I needed. I need to run this before bigint migration. For make the fied unsignedBigInteger datetime and date field must be valid. Otherwise its showing errors(I set them nullable in bigint migration).

    //@fahim - would it save some time on this cmd if you set the fields to be nullable, change them to null if value is 0000-00-00, then change to unsignbigint?
    //if that was done, this function wouldn't be needed
    //I can't even make this field nullble before those field has a valid date. "$table->dateTime('exp_date')->nullable()->change()" this type of code will also throw erros.
    foreach ($this->dateTimeNDateField as $table => $fields) {
      foreach ($fields as $field) {
        DB::statement("UPDATE `{$table}` set `{$field}` = '1971-01-01' where `{$field}` like '0000-00-00%'");
      }
    }
  }

  private function dateTimeAndDateFieldCorrection()
  {
    foreach ($this->dateTimeNDateField as $table => $fields) {
      foreach ($fields as $field) {
        DB::statement("UPDATE `{$table}` set `{$field}` = NULL where `{$field}` like '1971-01-01%'");
      }
    }
  }

  private function foreignKeyDataCorrection()
  {
    foreach ($this->foreignKeyField as $table => $fields) {
      foreach ($fields as $field) {
        DB::statement("UPDATE `{$table}` set `{$field}` = NULL where `{$field}` = 0");
      }
    }

    foreach ($this->foreignKeyCheckCorrection as $table => $fieldTable) {
      foreach ($fieldTable as $table2 => $field) {
        $table2 = str_replace('11', '', $table2);
        $table2 = str_replace('22', '', $table2);
        DB::statement("UPDATE `{$table}` set `{$field}` = NULL where `{$field}` = 0");

        $deleted = false;

        foreach ($this->deleteRowTable as $dTable => $drow) {
          if ($table === $dTable && $field === $drow) {
            DB::statement("DELETE FROM `{$table}` where `{$field}` not in (select id from `{$table2}`)");
            $deleted = true;
            break;
          }
        }

        if ($deleted === false) {
          if (strpos($field, 'parent') === false) {
            DB::statement("UPDATE `{$table}` set `{$field}` = NULL where `{$field}` is not null and `{$field}` not in (select id from `{$table2}`)");
          } else {
            $child_data = DB::select("select id from `{$table2}`");
            $ids = [];
            foreach ($child_data as $value) {
              $ids[] = $value->id;
            }

            //updating because the array was empty for me and caused the query to fail
            $query = "UPDATE `{$table}` set `{$field}` = NULL where `{$field}` is not null";
            if (count($ids)) {
              $query .= " and `{$field}` not in (" . implode(',', $ids) . ')';
            }

            DB::statement($query);
          }
        }
      }
    }
  }

  //    private function changeDecimalToInteger()
  //    {
  //        $tableFields = json_decode($this->jsonTableWithFloatField());
  //        foreach ($tableFields as $tableField) {
  //            $extra = $tableField->IS_NULLABLE === 'YES' ? '' : ' not null';
  //            if (strpos($tableField->COLUMN_NAME, 'qty') === true) {
  //                $sql_add_column = 'ALTER TABLE '.$tableField->TABLE_NAME.' ADD '.$tableField->COLUMN_NAME.'_int INT'.$extra;
  //                DB::statement($sql_add_column);
  //                $update = 'UPDATE '.$tableField->TABLE_NAME.' set '.$tableField->COLUMN_NAME.'_int = FLOOR('.$tableField->COLUMN_NAME.') ';
  //                DB::statement($update);
  //            } else {
  //                $sql_add_column = 'ALTER TABLE '.$tableField->TABLE_NAME.' ADD '.$tableField->COLUMN_NAME.'_int BIGINT'.$extra;
  //                DB::statement($sql_add_column);
  //                $update = 'UPDATE '.$tableField->TABLE_NAME.' set '.$tableField->COLUMN_NAME.'_int = REPLACE(CAST(REPLACE('.$tableField->COLUMN_NAME.",'%','') AS DECIMAL(10,4)),'.','') ";
  //                DB::statement($update);
  //            }
  //            $dropColumn = 'ALTER TABLE '.$tableField->TABLE_NAME.' DROP COLUMN '.$tableField->COLUMN_NAME;
  //            DB::statement($dropColumn);
  //            $renameColumn = 'ALTER TABLE  '.$tableField->TABLE_NAME.'  RENAME COLUMN '.$tableField->COLUMN_NAME.'_int TO '.$tableField->COLUMN_NAME;
  //            DB::statement($renameColumn);
  //        }
  //    }

  private function jsonTableWithFloatField()
  {
    return '[
            {
              "TABLE_NAME": "orders_discounts",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_products_discounts",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "accessories_fields_products",
              "COLUMN_NAME": "price_adjust_amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "affiliates_levels",
              "COLUMN_NAME": "order_rate",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "affiliates_levels",
              "COLUMN_NAME": "subscription_rate",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "affiliates_payments",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "affiliates_referrals",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "categories",
              "COLUMN_NAME": "max_price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "categories",
              "COLUMN_NAME": "min_price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "currencies",
              "COLUMN_NAME": "exchange_rate",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "discount_advantage",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "discount_rule_condition",
              "COLUMN_NAME": "required_cart_value",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "discounts_levels",
              "COLUMN_NAME": "action_percentage",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_availabilities",
              "COLUMN_NAME": "qty_max",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "distributors_availabilities",
              "COLUMN_NAME": "qty_min",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "distributors_canadapost",
              "COLUMN_NAME": "default_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_canadapost",
              "COLUMN_NAME": "discount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_endicia",
              "COLUMN_NAME": "default_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_endicia",
              "COLUMN_NAME": "discount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_fedex",
              "COLUMN_NAME": "default_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_fedex",
              "COLUMN_NAME": "discount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_flatrates",
              "COLUMN_NAME": "end_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_flatrates",
              "COLUMN_NAME": "flat_price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_flatrates",
              "COLUMN_NAME": "handling_fee",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_flatrates",
              "COLUMN_NAME": "start_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_methods",
              "COLUMN_NAME": "discount_rate",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_methods",
              "COLUMN_NAME": "flat_price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_methods",
              "COLUMN_NAME": "handling_fee",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipping_methods",
              "COLUMN_NAME": "handling_percentage",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipstation",
              "COLUMN_NAME": "default_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "distributors_shipstation",
              "COLUMN_NAME": "discount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "filters_pricing",
              "COLUMN_NAME": "price_max",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "filters_pricing",
              "COLUMN_NAME": "price_min",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "gift_cards",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "gift_cards_transactions",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "giftregistry_items",
              "COLUMN_NAME": "qty_purchased",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "giftregistry_items",
              "COLUMN_NAME": "qty_wanted",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "giftregistry_items_purchased",
              "COLUMN_NAME": "qty_purchased",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "inventory_gateways_orders",
              "COLUMN_NAME": "total_amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "inventory_gateways_sites",
              "COLUMN_NAME": "pricing_adjustment",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "loyaltypoints_levels",
              "COLUMN_NAME": "value_per_point",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "membership_levels",
              "COLUMN_NAME": "renewal_discount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "membership_subscriptions",
              "COLUMN_NAME": "amount_paid",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "membership_subscriptions",
              "COLUMN_NAME": "subscription_price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "options_templates_options_values",
              "COLUMN_NAME": "price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders",
              "COLUMN_NAME": "addtl_discount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders",
              "COLUMN_NAME": "addtl_fee",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders",
              "COLUMN_NAME": "payment_method_fee",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "orders_packages",
              "COLUMN_NAME": "dryice_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_products",
              "COLUMN_NAME": "product_price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_products",
              "COLUMN_NAME": "product_saleprice",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_products_customsinfo",
              "COLUMN_NAME": "customs_value",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_products_customsinfo",
              "COLUMN_NAME": "customs_weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_products_options",
              "COLUMN_NAME": "price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_shipments",
              "COLUMN_NAME": "cod_amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_shipments",
              "COLUMN_NAME": "insured_value",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_shipments",
              "COLUMN_NAME": "ship_cost",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_transactions",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_transactions",
              "COLUMN_NAME": "original_amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "orders_transactions_credits",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "payment_methods_limitcountries",
              "COLUMN_NAME": "fee",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "pricing_rules_levels",
              "COLUMN_NAME": "amount",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products",
              "COLUMN_NAME": "combined_stock_qty",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products",
              "COLUMN_NAME": "default_cost",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "products",
              "COLUMN_NAME": "weight",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_availability",
              "COLUMN_NAME": "qty_max",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "products_availability",
              "COLUMN_NAME": "qty_min",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "products_details",
              "COLUMN_NAME": "rating",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_distributors",
              "COLUMN_NAME": "cost",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "products_distributors",
              "COLUMN_NAME": "stock_qty",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_options_values",
              "COLUMN_NAME": "price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_pricing",
              "COLUMN_NAME": "max_qty",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_pricing",
              "COLUMN_NAME": "min_qty",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_pricing",
              "COLUMN_NAME": "price_reg",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_pricing",
              "COLUMN_NAME": "price_sale",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_pricing_temp",
              "COLUMN_NAME": "price_reg",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_pricing_temp",
              "COLUMN_NAME": "price_sale",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "products_reviews",
              "COLUMN_NAME": "rating",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "cart_items",
              "COLUMN_NAME": "price_reg",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "cart_items",
              "COLUMN_NAME": "price_sale",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "shipping_methods",
              "COLUMN_NAME": "price",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "shipping_methods",
              "COLUMN_NAME": "weight_limit",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "shipping_methods",
              "COLUMN_NAME": "weight_min",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "sites_payment_methods",
              "COLUMN_NAME": "fee",
              "IS_NULLABLE": "YES"
            },
            {
              "TABLE_NAME": "states",
              "COLUMN_NAME": "tax_rate",
              "IS_NULLABLE": "NO"
            },
            {
              "TABLE_NAME": "tax_rules",
              "COLUMN_NAME": "rate",
              "IS_NULLABLE": "NO"
            }
          ]';
  }
}
