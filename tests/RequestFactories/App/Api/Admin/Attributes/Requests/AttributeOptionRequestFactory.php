<?php

namespace Tests\RequestFactories\App\Api\Admin\Attributes\Requests;

use Domain\Products\Models\Attribute\Attribute;
use Worksome\RequestFactories\RequestFactory;

class AttributeOptionRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'display' => $this->faker->title,
            'rank' => $this->faker->randomDigit,
            'attribute_id'=>Attribute::firstOrFactory()->id,
            'status'=>true,
        ];
    }
}
