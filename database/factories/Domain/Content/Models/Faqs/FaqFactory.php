<?php

namespace Database\Factories\Domain\Content\Models\Faqs;

use Domain\Content\Models\Faqs\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->title,
            'answer' => $this->faker->words(3, true),
            'status' => $this->faker->boolean,
            'rank' => $this->faker->numberBetween(1,10),
            'url' => $this->faker->unique()->slug(2),
        ];
    }
}
