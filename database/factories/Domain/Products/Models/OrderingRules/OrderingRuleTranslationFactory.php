<?php

namespace Database\Factories\Domain\Products\Models\OrderingRules;

use Domain\Locales\Models\Language;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderingRuleTranslationFactory extends Factory
{
    protected $model = OrderingRuleTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'rule_id'=>OrderingRule::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
