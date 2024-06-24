<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettingsModuleValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteSettingsModuleValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteSettingsModuleValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'section'=>"Home",
            'site_id'=>Site::firstOrFactory(),
            'section_id' => LayoutSection::firstOrFactory(),
            'module_id' => Module::firstOrFactory(),
            'field_id'=>ModuleField::firstOrFactory(),
            'custom_value'=>$this->faker->words(2),
        ];
    }
}
