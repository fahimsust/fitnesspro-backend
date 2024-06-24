<?php

namespace Database\Factories\Domain\Products\Models\DatesAutoOrderRules;

use Domain\Products\Models\DatesAutoOrderRules\DatesAutoOrderRule;
use Domain\Products\Models\DatesAutoOrderRules\DatesAutoOrderRuleAction;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatesAutoOrderRuleActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatesAutoOrderRuleAction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dao_id' => DatesAutoOrderRule::firstOrFactory(),
            'status' => $this->faker->boolean,
            'criteria_startdatewithindays'=>$this->faker->randomNumber,
            'criteria_orderingruleid' => OrderingRule::firstOrFactory(),
            'criteria_siteid' => Site::firstOrFactory(),
            'changeto_orderingruleid' => OrderingRule::firstOrFactory(),
        ];
    }
}
