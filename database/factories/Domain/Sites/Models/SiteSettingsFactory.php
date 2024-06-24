<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_id' => Site::firstOrFactory(),
            'default_layout_id' => Layout::firstOrFactory(),
            'default_category_thumbnail_template' => ModuleTemplate::firstOrFactory(),
            'default_product_thumbnail_template' => ModuleTemplate::firstOrFactory(),
            'default_product_detail_template' => ModuleTemplate::firstOrFactory(),
            'default_product_zoom_template' => ModuleTemplate::firstOrFactory(),
            'default_feature_thumbnail_template' => ModuleTemplate::firstOrFactory(),
            'default_feature_count' => $this->faker->randomDigit(),
            'default_product_thumbnail_count' => $this->faker->randomDigit(),
            'default_show_categories_in_body' => $this->faker->boolean(),
            'search_layout_id' => Layout::firstOrFactory(),
            'search_thumbnail_template' => ModuleTemplate::firstOrFactory(),
            'home_feature_thumbnail_template' => ModuleTemplate::firstOrFactory(),
            'search_thumbnail_count' => $this->faker->randomDigit(),
            'home_feature_count' => $this->faker->randomDigit(),
            'home_feature_show' => $this->faker->boolean(),
            'home_feature_showsort' => $this->faker->boolean(),
            'home_feature_showmessage' => $this->faker->boolean(),
            'home_show_categories_in_body' => $this->faker->boolean(),
            'home_layout_id' => Layout::firstOrFactory(),
            'default_product_related_count' => $this->faker->randomDigit(),
            'default_product_brands_count' => $this->faker->randomDigit(),
            'default_feature_showsort' => $this->faker->boolean(),
            'default_product_thumbnail_showsort' => $this->faker->boolean(),
            'default_product_thumbnail_showmessage' => $this->faker->boolean(),
            'default_feature_showmessage' => $this->faker->boolean(),
            'default_product_related_template' => ModuleTemplate::firstOrFactory(),
            'default_product_brands_template' => ModuleTemplate::firstOrFactory(),
            'default_category_layout_id' => Layout::firstOrFactory(),
            'default_product_layout_id' => Layout::firstOrFactory(),
            'account_layout_id' => Layout::firstOrFactory(),
            'cart_layout_id' => Layout::firstOrFactory(),
            'checkout_layout_id' => Layout::firstOrFactory(),
            'page_layout_id' => Layout::firstOrFactory(),
            'affiliate_layout_id' => Layout::firstOrFactory(),
            'wishlist_layout_id' => Layout::firstOrFactory(),
            'default_module_template_id' => ModuleTemplate::firstOrFactory(),
            'default_module_custom_values' => $this->faker->text,
            'default_category_module_template_id' => ModuleTemplate::firstOrFactory(),
            'default_category_module_custom_values' => $this->faker->text,
            'default_product_module_template_id' => ModuleTemplate::firstOrFactory(),
            'default_product_module_custom_values' => $this->faker->text,
            'home_module_template_id' => ModuleTemplate::firstOrFactory(),
            'home_module_custom_values' => $this->faker->text,
            'account_module_template_id' => ModuleTemplate::firstOrFactory(),
            'account_module_custom_values' => $this->faker->text,
            'search_module_template_id' => ModuleTemplate::firstOrFactory(),
            'search_module_custom_values' => $this->faker->text,
            'cart_module_template_id' => ModuleTemplate::firstOrFactory(),
            'cart_module_custom_values' => $this->faker->text,
            'checkout_module_template_id' => ModuleTemplate::firstOrFactory(),
            'checkout_module_custom_values' => $this->faker->text,
            'page_module_template_id' => ModuleTemplate::firstOrFactory(),
            'page_module_custom_values' => $this->faker->text,
            'affiliate_module_template_id' => ModuleTemplate::firstOrFactory(),
            'affiliate_module_custom_values' => $this->faker->text,
            'wishlist_module_template_id' => ModuleTemplate::firstOrFactory(),
            'wishlist_module_custom_values' => $this->faker->text,
            'catalog_layout_id' => Layout::firstOrFactory(),
            'catalog_module_template_id' => ModuleTemplate::firstOrFactory(),
            'catalog_module_custom_values' => $this->faker->text,
            'catalog_show_products' => $this->faker->boolean(),
            'catalog_feature_show' => $this->faker->boolean(),
            'catalog_show_categories_in_body' => $this->faker->boolean(),
            'catalog_feature_count' => $this->faker->randomDigit(),
            'catalog_feature_thumbnail_template' => ModuleTemplate::firstOrFactory(),
            'catalog_feature_showsort' => $this->faker->boolean(),
            'catalog_feature_showmessage' => $this->faker->boolean(),
            'cart_addtoaction' => $this->faker->boolean(),
            'cart_orderonlyavailableqty' => $this->faker->boolean(),
            'checkout_process' => $this->faker->boolean(),
            'offline_layout_id' => Layout::firstOrFactory(),
            'filter_categories' => $this->faker->boolean(),
            'default_category_search_form_id' => SearchForm::firstOrFactory(),
            'recaptcha_key' => $this->faker->word,
            'recaptcha_secret' => $this->faker->word,
            'cart_allowavailability' => null
        ];
    }
}
