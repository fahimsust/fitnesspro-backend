<?php

namespace Database\Factories\Domain\Content\Models\Faqs;


use Domain\Content\Models\Faqs\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryFactory extends Factory
{
    protected $model = FaqCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'status' => $this->faker->boolean,
            'rank' => $this->faker->numberBetween(1,10),
            'url' => $this->faker->unique()->slug(2),
        ];
    }
}
