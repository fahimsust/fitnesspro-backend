<?php

namespace Database\Factories\Domain\Products\Models\Filters;

use Domain\Products\Enums\FilterTypes;
use Domain\Products\Models\Filters\Filter;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilterFactory extends Factory
{
    protected $model = Filter::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'label' => $this->faker->word,
            'status' => true,
            'rank' => random_int(1, 10),
            'show_in_search' => true,
            'type' => FilterTypes::Price
        ];
    }
}
