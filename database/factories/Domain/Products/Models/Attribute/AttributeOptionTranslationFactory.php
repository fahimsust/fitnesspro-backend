<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeOptionTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeOptionTranslationFactory extends Factory
{
    protected $model = AttributeOptionTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(3, true);
        return [
            'display' => $name,
            'value' => $name,
            'option_id'=>AttributeOption::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
