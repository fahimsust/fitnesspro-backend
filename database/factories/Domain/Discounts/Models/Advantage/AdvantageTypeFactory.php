<?php

namespace Database\Factories\Domain\Discounts\Models\Advantage;

use Domain\Discounts\Models\Advantage\AdvantageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvantageTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvantageType::class;

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
