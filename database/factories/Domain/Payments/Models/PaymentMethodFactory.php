<?php

namespace Database\Factories\Domain\Payments\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Events\Models\Event;
use Domain\Payments\Models\PaymentGateway;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'display' => $this->faker->name,
            'gateway_id' => PaymentGateway::firstOrFactory(),
            'status' => true,
            'limitby_country' => 0,
            'feeby_country' => 0,
        ];
    }
}
