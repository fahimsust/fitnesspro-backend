<?php

namespace Database\Factories\Domain\Modules\Models;

use Domain\Modules\Models\ModuleTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModuleTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'parent_template_id' => null,
        ];
    }
}
