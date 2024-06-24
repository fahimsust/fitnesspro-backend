<?php

namespace Tests\RequestFactories\App\Api\Support\Requests;

use Domain\Support\Models\SupportDepartment;
use Worksome\RequestFactories\RequestFactory;

class SupportEmailRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'origin'=>$this->faker->randomElement(['web','mobile']),
            'message'=>$this->faker->text,
            'support_department_id'=>SupportDepartment::firstOrFactory()->id,
        ];
    }
}
