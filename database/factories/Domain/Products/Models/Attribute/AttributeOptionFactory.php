<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttributeOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(3, true);

        return [
            'attribute_id' => function () {
                return Attribute::firstOrFactory()->id;
            },
            'display' => $name,
            'value' => $name,
            'rank' => $this->faker->randomDigit,
            'status' => true,
        ];
    }
}
