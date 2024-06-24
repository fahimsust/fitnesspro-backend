<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table_to_rename_array = [
        '`accounts-membership-attributes`',
        '`accounts-membership-attributes-sections`',
        '`accounts-membership-levels`',
        '`accounts-membership-levels_attributes`',
        '`accounts-membership-levels_settings`',
        '`accounts-memberships_payment_methods`',
        '`accounts-specialties_products`',
        '`accounts-statuses`',
        '`accounts-types`',
        '`accounts-types_categories`',
        '`accounts-types_products`',
        '`accounts-types_restrictordering`',
        '`attributes-packages`',
        '`attributes-packages_sets`',
        '`attributes-sets`',
        '`attributes-sets_attributes`',
        '`attributes-types`',
        '`discounts-levels`',
        '`discounts-levels_products`',
        '`faqs-categories_translations`',
        '`modules-templates`',
        '`modules-templates_modules`',
        '`modules-templates_sections`',
        '`orders-statuses`',
        '`pages-categories`',
        '`pages-categories_pages`',
        '`products-availability`',
        '`products-children_options`',
        '`products-rules-fulfillment`',
        '`products-rules-fulfillment_conditions`',
        '`products-rules-fulfillment_conditions_items`',
        '`products-rules-fulfillment_distributors`',
        '`products-rules-fulfillment_rules`',
        '`products-rules-ordering`',
        '`products-rules-ordering_conditions`',
        '`products-rules-ordering_conditions_items`',
        '`products-rules-ordering_rules`',
        '`products-types`',
        '`products-types_attributes-sets`',
        '`products_options-types`',
        '`tax_rules_product-types`',
    ];

    private $table_to_rename = [
        ['`accounts-specialties`' => 'account_specialties'],
        ['`faqs-categories`' => 'faq_categories'],
        ['`menus-links`' => 'menu_links'],
        ['`mods_resort_details-amenities`' => 'mod_resort_details_amenities'],
    ];

    private function getTableNameWithIndex()
    {
        foreach ($this->table_to_rename_array as $value) {
            $new_table = str_replace('-', '_', $value);
            $this->table_to_rename[] = [$value => $new_table];
        }
    }

    public function up()
    {
        $this->getTableNameWithIndex();
        foreach ($this->table_to_rename as $value) {
            foreach ($value as $old_name => $new_name) {
                DB::statement("RENAME TABLE $old_name TO $new_name");
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getTableNameWithIndex();
        foreach ($this->table_to_rename as $value) {
            foreach ($value as $old_name => $new_name) {
                DB::statement("RENAME TABLE $new_name TO $old_name");
            }
        }
    }
};
