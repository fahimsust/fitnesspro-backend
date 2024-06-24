<?php

namespace Tests\RequestFactories\App\Api\Admin\CustomForms\Requests;

use Domain\CustomForms\Models\CustomField;
use Worksome\RequestFactories\RequestFactory;

class CustomFieldOptionRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'value' => $this->faker->name,
            'display' => $this->faker->name,
            'rank'=>$this->faker->randomDigit,
            'field_id'=>CustomField::firstOrFactory()->id
        ];
    }
}
