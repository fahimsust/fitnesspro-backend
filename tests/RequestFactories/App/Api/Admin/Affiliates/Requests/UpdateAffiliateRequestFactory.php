<?php

namespace Tests\RequestFactories\App\Api\Admin\Affiliates\Requests;

use Domain\Addresses\Models\Address;
use Domain\Affiliates\Models\AffiliateLevel;
use Worksome\RequestFactories\RequestFactory;

class UpdateAffiliateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $password = $this->faker->password(8, 16);

        return [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => $password,
            'password_confirmation' => $password,
            'phone' => $this->faker->phoneNumber,
            'affiliate_level_id' => AffiliateLevel::firstOrFactory()->id,
            'status' => 1,
            'account_id' => null,
        ];
    }
}
