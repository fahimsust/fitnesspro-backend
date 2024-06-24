<?php

namespace Database\Factories\Domain\Content\Models\Pages;

use Domain\Content\Models\Pages\PageSettingsTemplate;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageSettingsTemplateFactory extends Factory
{
    protected $model = PageSettingsTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'layout_id'=>Layout::firstOrFactory(),
            'name' => $this->faker->name,
            'module_template_id'=>ModuleTemplate::firstOrFactory(),
            'module_custom_values' => $this->faker->words(2,true)
        ];
    }
}
