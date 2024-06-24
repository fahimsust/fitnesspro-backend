<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\AttributeSet;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeSetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttributeSet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
        ];
    }
}
