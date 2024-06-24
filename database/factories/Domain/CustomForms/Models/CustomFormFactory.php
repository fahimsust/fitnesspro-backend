<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\CustomForm;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomForm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'status' => true,
        ];
    }
}
