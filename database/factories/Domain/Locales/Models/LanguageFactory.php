<?php

namespace Database\Factories\Domain\Locales\Models;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Language::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'name' => $faker->name,
            'code' => $faker->languageCode,
            'status' => 1,
        ];
    }
}