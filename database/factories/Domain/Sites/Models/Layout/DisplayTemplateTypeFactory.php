<?php

namespace Database\Factories\Domain\Sites\Models\Layout;

use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisplayTemplateTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DisplayTemplateType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
