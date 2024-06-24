<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteMessageTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteMessageTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteMessageTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_id' => Site::firstOrFactory(),
            'html' => '<p>Here is the header</p><hr><p>{PLACEHOLDER}</p><hr><p>Here is footer</p>',
            'alt' => "Here is the header\r\n====\r\n{PLACEHOLDER}\r\n====\r\nHere is the footer",
        ];
    }
}
