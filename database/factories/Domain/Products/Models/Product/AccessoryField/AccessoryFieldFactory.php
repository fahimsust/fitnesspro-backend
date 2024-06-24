<?php

namespace Database\Factories\Domain\Products\Models\Product\AccessoryField;

use Domain\Products\Enums\AccessoryFieldTypes;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccessoryField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'label' => $this->faker->word,
            'field_type' => $this->faker->randomElement(
                AccessoryFieldTypes::cases()
            ),
            'required' => $this->faker->boolean(),
            'select_display' => $this->faker->word,
            'select_auto' => $this->faker->boolean(),
            'status' => $this->faker->boolean()
        ];
    }
}
