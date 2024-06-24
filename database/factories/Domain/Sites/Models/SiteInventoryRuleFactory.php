<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Sites\Models\InventoryRule;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteInventoryRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteInventoryRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteInventoryRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rule_id' => InventoryRule::firstOrFactory(),
            'site_id' => Site::firstOrFactory()
        ];
    }
}
