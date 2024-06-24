<?php

namespace Database\Factories\Domain\Tax\Models;

use Domain\Products\Models\Product\ProductType;
use Domain\Tax\Models\TaxRule;
use Domain\Tax\Models\TaxRuleProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxRuleProductTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxRuleProductType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_id' => ProductType::firstOrFactory(),
            'tax_rule_id' => TaxRule::firstOrFactory(),
        ];
    }
}
