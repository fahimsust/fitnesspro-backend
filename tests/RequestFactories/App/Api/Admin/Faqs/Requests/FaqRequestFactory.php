<?php

namespace Tests\RequestFactories\App\Api\Admin\Faqs\Requests;

use Domain\Content\Models\Faqs\FaqCategory;
use Worksome\RequestFactories\RequestFactory;

class FaqRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'question' => $this->faker->title,
            'answer' => $this->faker->words(3, true),
            'status' => $this->faker->boolean,
            'rank' => $this->faker->numberBetween(1,10),
            'url' => $this->faker->unique()->slug(2),
            'categories_id'=>[FaqCategory::factory()->create()->id]
        ];
    }
}
