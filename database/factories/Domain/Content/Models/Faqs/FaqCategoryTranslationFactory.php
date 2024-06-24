<?php

namespace Database\Factories\Domain\Content\Models\Faqs;

use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqCategoryTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryTranslationFactory extends Factory
{
    protected $model = FaqCategoryTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'categories_id'=>FaqCategory::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
