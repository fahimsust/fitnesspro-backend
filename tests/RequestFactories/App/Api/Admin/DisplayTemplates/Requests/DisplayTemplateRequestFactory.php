<?php

namespace Tests\RequestFactories\App\Api\Admin\DisplayTemplates\Requests;

use Domain\Sites\Models\Layout\DisplayTemplateType;
use Worksome\RequestFactories\RequestFactory;

class DisplayTemplateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'name' => substr($faker->words(3, true), 0, 9),
            'include' => $faker->words(3, true),
            'image_width' => substr($faker->words(3, true), 0, 9),
            'image_height' => substr($faker->words(3, true), 0, 9),
            'type_id' => DisplayTemplateType::firstOrFactory()->id
        ];
    }
}
