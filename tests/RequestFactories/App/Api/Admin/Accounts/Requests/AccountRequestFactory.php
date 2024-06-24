<?php

namespace Tests\RequestFactories\App\Api\Admin\Accounts\Requests;

use Domain\Accounts\Models\AccountStatus;
use Domain\Accounts\Models\AccountType;
use Domain\Sites\Models\Site;
use Worksome\RequestFactories\RequestFactory;

class AccountRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'email' => $faker->email,
            'username' => $faker->userName,
            'password' => $faker->password(6, 6),
            'status_id' => AccountStatus::firstOrFactory()->id,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'site_id' => Site::firstOrFactory()->id,
            'phone' => $this->faker->phoneNumber,
            'profile_public'=>1,
            'type_id' => AccountType::firstOrFactory()->id
        ];
    }
}
