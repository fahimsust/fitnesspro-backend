<?php

namespace Database\Factories\Domain\Products\Models\Category\Rule;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryRuleAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryRuleAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rule_id' =>CategoryRule::firstOrFactory(),
            'value_id' =>AttributeOption::firstOrFactory(),
            'set_id' =>AttributeSet::firstOrFactory(),
            'matches' => 0,
        ];
    }
}
