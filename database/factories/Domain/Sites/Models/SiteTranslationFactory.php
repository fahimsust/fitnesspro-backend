<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteTranslationFactory extends Factory
{
    protected $model = SiteTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        return [
            'meta_title' => $faker->company,
            'meta_keywords' => $faker->words(3, true),
            'meta_desc' => substr($faker->words(10, true), 0, 255),
            'offline_message' => substr($faker->words(10, true), 0, 255),
            'site_id'=>Site::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
