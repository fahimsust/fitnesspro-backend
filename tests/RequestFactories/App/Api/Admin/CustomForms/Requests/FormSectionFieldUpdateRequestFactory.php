<?php

namespace Tests\RequestFactories\App\Api\Admin\CustomForms\Requests;

use Worksome\RequestFactories\RequestFactory;

class FormSectionFieldUpdateRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'rank' => $this->faker->randomNumber,
            'required' => false,
            'new_row' => false,
        ];
    }
}
