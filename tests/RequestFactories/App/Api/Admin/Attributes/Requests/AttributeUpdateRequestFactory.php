<?php

namespace Tests\RequestFactories\App\Api\Admin\Attributes\Requests;

use Domain\Products\Models\Attribute\AttributeType;
use Worksome\RequestFactories\RequestFactory;

class AttributeUpdateRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->title,
            'show_in_details' => $this->faker->boolean,
            'show_in_search' => $this->faker->boolean,
            'type_id'=>AttributeType::firstOrFactory()->id,
        ];
    }
}
