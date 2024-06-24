<?php

namespace Database\Factories\Domain\Products\Models\Product\Settings;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'settings_template_id' => ProductSettingsTemplate::firstOrFactory(),
            'layout_id' => Layout::firstOrFactory(),
            'module_template_id' => ModuleTemplate::firstOrFactory(),
            'product_detail_template' => DisplayTemplate::firstOrFactory(),
            'product_thumbnail_template' => DisplayTemplate::firstOrFactory(),
            'product_zoom_template' => DisplayTemplate::firstOrFactory(),
            'product_related_count' => mt_rand(3, 12),
            'product_brands_count' => mt_rand(3, 12),
            'product_related_template' => DisplayTemplate::firstOrFactory(),
            'product_brands_template' => DisplayTemplate::firstOrFactory(),
            'show_brands_products' => $this->faker->boolean(),
            'show_related_products' => $this->faker->boolean(),
            'show_specs' => $this->faker->boolean(),
            'show_reviews' => $this->faker->boolean(),
            'use_default_related' => $this->faker->boolean(),
            'use_default_brand' => $this->faker->boolean(),
            'use_default_specs' => $this->faker->boolean(),
            'use_default_reviews' => $this->faker->boolean(),
            'module_custom_values' => '',
            'module_override_values' => '',
        ];
    }
}
