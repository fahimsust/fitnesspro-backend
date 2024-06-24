<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Discounts\Models\Rule\Condition\ConditionCountry;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Locales\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionCountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionCountry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'country_id' => Country::firstOrFactory()
        ];
    }
}
