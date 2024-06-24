<?php

namespace Database\Factories\Domain\Locales\Models;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Region::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' => Country::firstOrFactory(),
            'rank' => $this->faker->randomDigit(),
        ];
    }
}
