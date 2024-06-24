<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettingsSiteModuleValue;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorySettingsSiteModuleValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategorySettingsSiteModuleValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id'=>Category::firstOrFactory(),
            'site_id'=>Site::firstOrFactory(),
            'section_id' => LayoutSection::firstOrFactory(),
            'module_id' => Module::firstOrFactory(),
            'field_id'=>ModuleField::firstOrFactory(),
            'custom_value'=>$this->faker->words(2),
        ];
    }
}
