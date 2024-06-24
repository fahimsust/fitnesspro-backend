<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomFieldTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFieldTranslationFactory extends Factory
{
    protected $model = CustomFieldTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'display' => $this->faker->name,
            'field_id'=>CustomField::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
