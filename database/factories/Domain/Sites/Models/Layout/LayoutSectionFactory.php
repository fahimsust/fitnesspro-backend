<?php

namespace Database\Factories\Domain\Sites\Models\Layout;

use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class LayoutSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LayoutSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'display' => $this->faker->name,
            'rank'=>$this->faker->randomDigit,
        ];
    }
}
