<?php

namespace Database\Factories\Domain\Affiliates\Models;

use Domain\Affiliates\Models\AffiliateLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AffiliateLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AffiliateLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'points' => [
                'order' => 20,
                'subscription' => [],
            ]
        ];
    }
}
