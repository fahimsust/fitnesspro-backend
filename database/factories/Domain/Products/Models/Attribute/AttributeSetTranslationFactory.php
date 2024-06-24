<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeSetTranslationFactory extends Factory
{
    protected $model = AttributeSetTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'set_id'=>AttributeSet::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
