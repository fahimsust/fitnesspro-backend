<?php

namespace Database\Factories\Domain\Accounts\Models\Registration;

use Domain\Accounts\Enums\RegistrationStatus;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Affiliates\Models\Affiliate;
use Domain\Orders\Models\Carts\Cart;
use Domain\Payments\Models\PaymentMethod;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'site_id' => Site::firstOrFactory(),
            'account_id' => Account::firstOrFactory(),
            'status' => RegistrationStatus::OPEN
        ];
    }

    public function readyToPlaceOrder()
    {
        return $this->state(function (array $attributes) {
            return [
                'level_id' => MembershipLevel::factory()
                    ->for(Product::factory()->withDefaultDistributor()->create(), 'product')
                    ->create()
                    ->id,
                'affiliate_id' => Affiliate::firstOrFactory(),
                'status' => RegistrationStatus::OPEN,
                'payment_method_id' => PaymentMethod::find(2)
                    ?? throw new \Exception('No payment methods found. Did you seed the database?'),
                'cart_id' => Cart::firstOrFactory([
                    'account_id' => Account::firstOrFactory()
                ]),
            ];
        });
    }
}
