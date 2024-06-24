<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\AttributeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttributeType::class;

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
