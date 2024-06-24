<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\FormSectionField;
use Domain\CustomForms\Models\CustomFieldOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFieldOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomFieldOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'field_id' => FormSectionField::firstOrFactory(),
            'display' => $this->faker->name,
            'value' => $this->faker->name,
        ];
    }
}
