<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionField;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormSectionFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormSectionField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'section_id' => FormSection::firstOrFactory(),
            'field_id' => CustomField::firstOrFactory(),
            'required' => true,
            'rank' => $this->faker->randomDigit,
            'new_row' => true,
        ];
    }
}
