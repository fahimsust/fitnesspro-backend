<?php

namespace Database\Factories\Domain\Products\Models\Category\Rule;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\MatchAllAnyString;

class CategoryRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => function () {
                return Category::firstOrFactory()->id;
            },
            'match_type' => MatchAllAnyString::ANY,
        ];
    }
}
