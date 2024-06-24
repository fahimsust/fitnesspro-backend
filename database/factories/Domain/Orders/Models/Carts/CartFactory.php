<?php

namespace Database\Factories\Domain\Orders\Models\Carts;

use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Carts\Cart;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => $this->faker->randomElement([
                Account::firstOrFactory(),
                null
            ]),
            'site_id' => Site::firstOrFactory()
        ];
    }
}
