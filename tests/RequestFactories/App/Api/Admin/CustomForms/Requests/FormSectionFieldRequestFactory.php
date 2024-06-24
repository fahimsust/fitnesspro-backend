<?php

namespace Tests\RequestFactories\App\Api\Admin\CustomForms\Requests;

use Domain\CustomForms\Models\FormSection;
use Worksome\RequestFactories\RequestFactory;

class FormSectionFieldRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
            'display' => $this->faker->name,
            'section_id'=>FormSection::firstOrFactory()->id
        ];
    }
}
