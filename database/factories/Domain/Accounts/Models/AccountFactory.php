<?php

namespace Database\Factories\Domain\Accounts\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountType;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'email' => $faker->email,
            'username' => $faker->userName,
            'password' => Hash::make(123456),
            'status_id' => 1,
            'lastlogin_at'=>Carbon::yesterday(),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'site_id' => Site::firstOrFactory(),
            'phone' => $this->faker->phoneNumber,
            'type_id' => AccountType::firstOrFactory()
        ];
    }
}
