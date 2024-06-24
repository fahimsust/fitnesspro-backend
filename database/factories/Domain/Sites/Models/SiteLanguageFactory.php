<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'language_id' => Language::firstOrFactory(),
            'site_id' => Site::firstOrFactory()
        ];
    }
}
