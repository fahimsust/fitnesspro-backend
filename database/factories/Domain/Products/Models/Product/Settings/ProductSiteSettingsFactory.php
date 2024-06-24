<?php

namespace Database\Factories\Domain\Products\Models\Product\Settings;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSiteSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductSiteSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'site_id' => Site::firstOrFactory(),
            'settings_template_id_default'=>1,
            'layout_id_default'=>1,
            'module_template_id_default'=>1,
            'product_detail_template_default'=>null,
            'product_thumbnail_template_default'=>null,
            'product_zoom_template_default'=>null,
            'settings_template_id'=>ProductSettingsTemplate::firstOrFactory(),
            'layout_id'=>Layout::firstOrFactory(),
            'module_template_id'=>ModuleTemplate::firstOrFactory(),
            'product_detail_template' => null,
            'product_thumbnail_template' => null,
            'product_zoom_template' => null,

        ];
    }
}
