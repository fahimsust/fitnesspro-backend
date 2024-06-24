<?php

namespace Tests\RequestFactories\App\Api\Admin\Addresses\Requests;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Worksome\RequestFactories\RequestFactory;

class CreateAddressRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'label' => $this->faker->name,
            'email' => $this->faker->email,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'address_1' => $this->faker->streetAddress,
            'address_2' => $this->faker->address,
            'city' => $this->faker->city,
            'country_id' => Country::firstOrFactory()->id,
            'state_id' => StateProvince::firstOrFactory()->id,
            'postal_code' => $this->faker->postcode,
        ];
    }
}
