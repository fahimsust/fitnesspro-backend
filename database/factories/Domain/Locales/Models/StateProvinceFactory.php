<?php

namespace Database\Factories\Domain\Locales\Models;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateProvinceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StateProvince::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'name' => $faker->state,
            'abbreviation' => $faker->stateAbbr,
            'country_id' => Country::firstOrFactory(),
            'tax_rate' => $faker->randomFloat(2, 0, 6),
        ];
    }
}
