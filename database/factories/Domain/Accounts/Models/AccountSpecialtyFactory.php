<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountSpecialty;
use Domain\Accounts\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountSpecialtyFactory extends Factory
{
    protected $model = AccountSpecialty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::firstOrFactory(),
            'specialty_id' => Specialty::firstOrFactory(),
            'approved' => (int) $this->faker->boolean(),
        ];
    }
}
