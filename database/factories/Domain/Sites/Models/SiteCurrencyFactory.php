<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Locales\Models\Currency;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCurrency;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteCurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteCurrency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'currency_id' => Currency::firstOrFactory(),
            'site_id' => Site::firstOrFactory()
        ];
    }
}
