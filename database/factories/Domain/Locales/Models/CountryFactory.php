<?php

namespace Database\Factories\Domain\Locales\Models;

use Domain\Locales\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'name' => $faker->country,
            'abbreviation' => $faker->countryCode,
            'iso_code' => $faker->countryISOAlpha3,
            'rank' => 0,
        ];
    }
}
