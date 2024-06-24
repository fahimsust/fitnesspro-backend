<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormSectionTranslationFactory extends Factory
{
    protected $model = FormSectionTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'section_id'=>FormSection::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
