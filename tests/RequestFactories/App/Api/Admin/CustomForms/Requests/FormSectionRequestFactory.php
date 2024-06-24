<?php

namespace Tests\RequestFactories\App\Api\Admin\CustomForms\Requests;

use Domain\CustomForms\Models\CustomForm;
use Worksome\RequestFactories\RequestFactory;

class FormSectionRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'title' => $this->faker->name,
            'rank' => $this->faker->randomNumber,
            'form_id'=>CustomForm::firstOrFactory()->id
        ];
    }
}
