<?php

namespace Database\Factories\Domain\Modules\Models;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleTemplateModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModuleTemplateModule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'template_id' => ModuleTemplate::firstOrFactory(),
            'section_id' => LayoutSection::firstOrFactory(),
            'module_id' => Module::firstOrFactory(),
            'rank' => 0,
        ];
    }
}
