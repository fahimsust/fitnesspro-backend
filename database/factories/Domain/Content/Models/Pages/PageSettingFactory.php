<?php

namespace Database\Factories\Domain\Content\Models\Pages;

use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageSetting;
use Domain\Content\Models\Pages\PageSettingsTemplate;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageSettingFactory extends Factory
{
    protected $model = PageSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_id'=>Page::firstOrFactory(),
            'settings_template_id'=>PageSettingsTemplate::firstOrFactory(),
            'module_template_id'=>ModuleTemplate::firstOrFactory(),
            'layout_id'=>Layout::firstOrFactory(),
            'module_custom_values' => $this->faker->title,
            'module_override_values' => $this->faker->title
        ];
    }
}
