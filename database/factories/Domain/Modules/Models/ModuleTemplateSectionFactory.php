<?php

namespace Database\Factories\Domain\Modules\Models;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateSection;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleTemplateSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModuleTemplateSection::class;

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
        ];
    }
}
