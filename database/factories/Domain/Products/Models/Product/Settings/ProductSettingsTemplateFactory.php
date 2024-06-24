<?php

namespace Database\Factories\Domain\Products\Models\Product\Settings;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSettingsTemplateFactory extends Factory
{
    protected $model = ProductSettingsTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'settings_template_id' => null,
            'layout_id' => Layout::firstOrFactory(),
            'module_template_id' => ModuleTemplate::firstOrFactory(),
            'product_detail_template' => DisplayTemplate::firstOrFactory(),
            'product_thumbnail_template' => DisplayTemplate::firstOrFactory(),
            'product_zoom_template' => DisplayTemplate::firstOrFactory(),
            'name' => $this->faker->word,
        ];
    }
}
