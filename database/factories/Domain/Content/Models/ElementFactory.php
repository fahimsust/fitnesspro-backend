<?php

namespace Database\Factories\Domain\Content\Models;

use Domain\Content\Models\Element;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElementFactory extends Factory
{
    protected $model = Element::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'notes' => $this->faker->word,
            'content' => $this->faker->words(3, true),
            'status' => $this->faker->boolean
        ];
    }
}
