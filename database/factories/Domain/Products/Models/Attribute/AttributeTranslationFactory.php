<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeTranslationFactory extends Factory
{
    protected $model = AttributeTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'attribute_id'=>Attribute::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
