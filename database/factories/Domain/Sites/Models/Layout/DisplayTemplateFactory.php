<?php

namespace Database\Factories\Domain\Sites\Models\Layout;

use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisplayTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DisplayTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_id' => DisplayTemplateType::firstOrFactory(),
            'name' => $this->faker->word,
            'include' => $this->faker->word,
            'image_width' => mt_rand(100, 500),
            'image_height' => mt_rand(100, 500),
        ];
    }
}
