<?php

namespace Database\Factories\Domain\Addresses\Models;

use Domain\Addresses\Models\Address;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'label' => $faker->word,
            'company' => $faker->company,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'address_1' => $faker->streetAddress,
            'address_2' => $faker->address,
            'city' => $faker->city,
            'country_id' => Country::firstOrFactory(),
            'state_id' => StateProvince::firstOrFactory(),
            'postal_code' => $faker->postcode,
            'email' => $faker->email,
            'phone' => Str::substr($faker->phoneNumber, 0, 15),
            'is_residential' => $faker->numberBetween(0, 2),
        ];
    }
}
