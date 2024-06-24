<?php

namespace Database\Factories\Domain\Content\Models\Faqs;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqTranslationFactory extends Factory
{
    protected $model = FaqTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->title,
            'answer' => $this->faker->words(3, true),
            'faqs_id'=>Faq::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
