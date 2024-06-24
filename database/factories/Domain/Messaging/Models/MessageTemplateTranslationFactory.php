<?php

namespace Database\Factories\Domain\Messaging\Models;

use Domain\Locales\Models\Language;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Messaging\Models\MessageTemplateTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageTemplateTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MessageTemplateTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'subject' => $faker->words(4, true),
            'alt_body' => $faker->paragraphs(3, true),
            'html_body' => $faker->randomHtml(3),
            'message_template_id' => MessageTemplate::firstOrFactory(),
            'language_id' => Language::firstOrFactory()
        ];
    }
}
