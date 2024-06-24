<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Content\Models\Image;
use Worksome\RequestFactories\RequestFactory;

class ProductImageRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'imafe_id' => Image::factory()->create()->id,
            'caption' => $this->faker->sentence(3),
            'rank' => $this->faker->randomNumber(1),
            'show_in_gallery' => $this->faker->boolean()
        ];
    }
}
