<?php

namespace Database\Factories\Domain\Products\Models\OrderingRules;

use Domain\Accounts\Models\Specialty;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingConditionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderingConditionItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderingConditionItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => OrderingCondition::firstOrFactory(),
            'item_id' => Specialty::firstOrFactory(),
        ];
    }
}
