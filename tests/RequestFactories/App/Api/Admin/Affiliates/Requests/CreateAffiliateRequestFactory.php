<?php

namespace Tests\RequestFactories\App\Api\Admin\Affiliates\Requests;

use Domain\Affiliates\Models\AffiliateLevel;
use Worksome\RequestFactories\RequestFactory;

class CreateAffiliateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $password = $this->faker->password(8, 16);

        return [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => $password,
            'password_confirmation' => $password,
            'affiliate_level_id' => AffiliateLevel::firstOrFactory()->id,
            'account_id' => null,
        ];
    }
}
