<?php

namespace Tests\RequestFactories\App\Api\Accounts\Requests\Registration;

use Worksome\RequestFactories\RequestFactory;
use Domain\Accounts\Models\Account;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Support\Str;

class CreateAccountAddressRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $faker = $this->faker;

        return [
            'account_id' => Account::firstOrFactory()->id,
            'label' => $faker->word,
            'is_billing' => $faker->boolean(),
            'is_shipping' => $faker->boolean(),
            'company' => $faker->company,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'address_1' => $faker->streetAddress,
            'city' => $faker->city,
            'country_id' => Country::firstOrFactory()->id,
            'state_id' => StateProvince::firstOrFactory()->id,
            'postal_code' => $faker->postcode,
            'email' => $faker->email,
            'phone' => Str::substr($faker->phoneNumber, 0, 15),
            'is_residential' => $faker->numberBetween(0, 2),
            'status' => $faker->boolean(),
            'old_billingid' => 0,
            'old_shippingid' => 0,
        ];
    }
}
