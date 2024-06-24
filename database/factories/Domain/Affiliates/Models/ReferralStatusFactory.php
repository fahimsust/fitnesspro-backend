<?php

namespace Database\Factories\Domain\Affiliates\Models;

use Domain\Affiliates\Models\ReferralStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferralStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReferralStatus::class;

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
