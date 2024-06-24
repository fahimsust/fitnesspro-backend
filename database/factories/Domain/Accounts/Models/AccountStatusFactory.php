<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\AccountStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
