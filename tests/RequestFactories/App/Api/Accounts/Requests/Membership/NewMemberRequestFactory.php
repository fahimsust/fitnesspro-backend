<?php

namespace Tests\RequestFactories\App\Api\Accounts\Requests\Membership;

use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\Affiliate;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Domain\Products\Models\Product\Product;
use Worksome\RequestFactories\RequestFactory;

class NewMemberRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $password = $this->faker->password;
        $email = $this->faker->email;

        return [
            'email' => $email,
            'email_confirmation' => $email,
            'username' => $this->faker->userName(),
            'password' => $password,
            'password_confirmation' => $password,
            'phone' => $this->faker->phoneNumber,
            'type_id' => AccountType::firstOrFactory()->id,
            'cim_profile_id' => null,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'specialties' => [1, 2],
            'address_1' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'country_id' => Country::firstOrFactory()->id,
            'state_id' => StateProvince::firstOrFactory()->id,
            'postal_code' => $this->faker->postcode,
            'company' => $this->faker->company,

//            'level_id' => MembershipLevel::firstOrFactory(),
//            'amount_paid' => $this->faker->randomFloat(),
//            'subscription_price' => $this->faker->randomFloat(),
//            'product_id' => Product::firstOrFactory(),
        ];
    }
    public function withMembershipAndAffiliate($amountPaid): self
    {
        return $this->state([
            'level_id' => MembershipLevel::firstOrFactory()->id,
            'amount_paid' => $amountPaid,
            'affiliate_id' => Affiliate::firstOrFactory()->id,
            'order_id' => Order::firstOrFactory()->id,
            'subscription_price' => '100.06',
            'product_id' => Product::firstOrFactory()->id,
        ]);
    }
}
