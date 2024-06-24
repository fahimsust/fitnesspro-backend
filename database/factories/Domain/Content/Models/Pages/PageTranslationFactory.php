<?php

namespace Database\Factories\Domain\Content\Models\Pages;

use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageTranslationFactory extends Factory
{
    protected $model = PageTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
            'page_id'=>Page::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
