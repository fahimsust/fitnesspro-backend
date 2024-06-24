<?php

namespace Database\Factories\Domain\Support\Models;

use Domain\Support\Models\SupportDepartment;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportDepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SupportDepartment::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'subject' => $this->faker->name
        ];
    }
}
