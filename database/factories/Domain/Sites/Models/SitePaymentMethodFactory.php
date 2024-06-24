<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use function config;

class SitePaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SitePaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_id' => Site::firstOrFactory(),
            'payment_method_id' => PaymentMethod::firstOrFactory(),
            'gateway_account_id' => PaymentAccount::firstOrFactory(),
            'fee' => $this->faker->randomDigit(),
        ];
    }
}
