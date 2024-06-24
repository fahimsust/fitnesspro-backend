<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\CustomField;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'display' => $name,
            'name' => $name,
            'type' => 0,
            'required' => true,
            'rank' => $this->faker->randomDigit,
            'cssclass' => '',
            'options' => '',
            'specs' => '',
            'status' => 1,
        ];
    }
}
