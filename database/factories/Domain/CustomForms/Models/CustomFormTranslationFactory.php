<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\CustomFormTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFormTranslationFactory extends Factory
{
    protected $model = CustomFormTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'form_id'=>CustomForm::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
