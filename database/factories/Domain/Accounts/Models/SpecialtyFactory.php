<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialtyFactory extends Factory
{
    protected $model = Specialty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => null,
            'name' => $this->faker->name,
            'rank' => 0,
            'status' => true,
        ];
    }
}
