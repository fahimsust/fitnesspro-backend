<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySettingsTemplateModuleValue;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorySettingsTemplateModuleValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategorySettingsTemplateModuleValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'settings_template_id'=>CategorySettingsTemplate::firstOrFactory(),
            'section_id' => LayoutSection::firstOrFactory(),
            'module_id' => Module::firstOrFactory(),
            'field_id'=>ModuleField::firstOrFactory(),
            'custom_value'=>$this->faker->words(2),
        ];
    }
}
