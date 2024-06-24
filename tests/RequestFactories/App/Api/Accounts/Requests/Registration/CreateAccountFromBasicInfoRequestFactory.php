<?php

namespace Tests\RequestFactories\App\Api\Accounts\Requests\Registration;


use Worksome\RequestFactories\RequestFactory;

class CreateAccountFromBasicInfoRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $password = "654321Ff!";
        $email = $this->faker->email;

        return [
            'email' => $email,
            'email_confirmation' => $email,
            'username' => $this->faker->userName(),
            'password' => $password,
            'password_confirmation' => $password,
            'phone' => $this->faker->phoneNumber,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName
        ];
    }
}
