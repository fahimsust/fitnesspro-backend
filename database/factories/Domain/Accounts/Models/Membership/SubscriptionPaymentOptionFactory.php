<?php

namespace Database\Factories\Domain\Accounts\Models\Membership;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentGateway;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionPaymentOptionFactory extends Factory
{
    protected $model = SubscriptionPaymentOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_method_id' => PaymentMethod::firstOrFactory(),
            'site_id' => Site::firstOrFactory(),
            'gateway_account_id' => PaymentAccount::firstOrFactory(),
        ];
    }
}
