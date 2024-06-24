<?php

namespace Database\Factories\Domain\Messaging\Models;

use Domain\Messaging\Models\MessageTemplate;
use Domain\Messaging\Models\MessageTemplateCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MessageTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'system_id' => $faker->unique()->randomNumber(),
            'name' => $faker->words(3, true),
            'subject' => $faker->words(4, true),
            'alt_body' => $faker->paragraphs(3, true),
            'html_body' => $faker->randomHtml(3),
            'note' => $faker->words(12, true),
            'category_id' => MessageTemplateCategory::firstOrFactory()
        ];
    }
}
