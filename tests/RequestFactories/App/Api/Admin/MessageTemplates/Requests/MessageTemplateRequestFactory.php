<?php

namespace Tests\RequestFactories\App\Api\Admin\MessageTemplates\Requests;

use Domain\Messaging\Models\MessageTemplateCategory;
use Worksome\RequestFactories\RequestFactory;

class MessageTemplateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $faker = $this->faker;
        //$categoryId = $faker->randomElement([MessageTemplateCategory::firstOrFactory()->id, $faker->word, []]);
        return [
            'name' => $faker->words(3, true),
            'subject' => $faker->words(4, true),
            'alt_body' => $faker->paragraphs(3, true),
            'html_body' => $faker->randomHtml(3),
            'note' => $faker->words(12, true),
            'category_id' => MessageTemplateCategory::firstOrFactory()->id,
        ];
    }
}
