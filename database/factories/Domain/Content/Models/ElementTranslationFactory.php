<?php

namespace Database\Factories\Domain\Content\Models;

use Domain\Content\Models\Element;
use Domain\Content\Models\ElementTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElementTranslationFactory extends Factory
{
    protected $model = ElementTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->words(3, true),
            'element_id'=>Element::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
